<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Room;
use App\Guest;
use App\Point;
use App\Round;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Cookie;
use App\Events\JoinEvent;
use Illuminate\Support\Facades\Crypt;

class JuegoController extends Controller
{

    public function createNuevo(Request $request)
    {
        $data= $request->validate([
            'alias' => 'sometimes',
            'room_name' => 'required|string',
            'user_id' => 'sometimes'
        ]);
        $room = new Room;
        $pwd = substr(str_shuffle("0123456789"), 0, 5);
        $room->password = Crypt::encryptString(strval(rand(10000,99999)));
        $room->status = true;
        $room->name = $data['room_name'];
        $room->save();
        $guest = $this->createGuest($room->id, $data['alias'], $data['user_id']);
        $room->owner_id = $guest->id;
        $room->save();
        $room->guest_key = $guest->guest_id;
        return $room;
    }

    public function index(Request $request, $room_id){
        $room = Room::with('guests', 'points', 'owner')->find($room_id);
        $room->password = Crypt::decryptString($room->password);
        return $room;
    }

    public function indexAvailable(){
        return Room::where('status', 1)->get();
    }
    
    public function joinRoom(Request $request){
        $data= $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'password' => 'required|max:5',
            'alias' => 'sometimes',
            'user_id' => 'nullable|exists:user,id',
        ]);
        $room = Room::find($data['room_id'])->first();
        if(!$room){
            abort(404);
        }
        $decrypted_pwd = Crypt::decryptString($room->password);
        if($decrypted_pwd != $data['password']){
            abort(404);
        }
        $guest = $this->createGuest($room->id, $data['alias'], $data['user_id']);
        broadcast(new JoinEvent($room->id, $guest))->toOthers();
        $room->guest_key = $guest->guest_id;
        return $room;
    }
    public function nextRound(Request $request, $room_id){
        $room = Room::with('points')->find($room_id);
        $data = $request->validate([
            'actual' => 'required|exists:rounds,id',
            'points' => 'required|array',
        ]);
        foreach($data['points'] as $round){
            $point = new Point();
            $point->room_id = $room->getKey();
            $point->round_id = $data['actual'];
            $point->guest_id = $round['guest_id'];
            $point->points = $round['points'];
            $point->save();
        }
        if($data['actual'] == 7){
            $room->status = false;
            $room->save();
        }
        broadcast(new JoinEvent($room->id, $room))->toOthers();
        return Room::with('points', 'guests', 'owner')->find($room_id);
    }

    public function record(Request $request){
        $user = auth()->user();
        if(!$user){
            abort(404);
        }
        $guests = Guest::with('room')->where('user_id', $user->getKey())->get();
        $record = [];
        foreach($guests as &$guest){
            $plays = Room::record($guest->room_id)->get();
            $plays = $this->roundsWonPerPlayer($plays, "guest_id");
            usort($plays, function ($guest1, $guest2) {
                return $guest1['points'] <=> $guest2['points'];
            });
            $place = 0;
            foreach($plays as $key=>$value){
                if($value['guest_id'] == $guest->getKey()){
                    $place = $key;
                break;
                }
            }
            $plays = $plays[$place];
            $plays['room'] = $guest->room;
            $plays['place'] = $place + 1;
            $record[] = $plays;
        }
        $response['user'] = $user;
        $response['record'] = $record;
        return $response;
    }
    public function getRounds(){
        return Round::all();
    }
    public function getWinners($room_id){
        $room = Room::record($room_id)->get();
        return $this->roundsWonPerPlayer($room, "guest_id");
    }

    function createGuest($room_id, $alias, $user_id = null){
        $cookie_val = md5($_SERVER['REMOTE_ADDR'] . time());
        $guest = new Guest;
        $guest->alias = $alias;
        $guest->room_id = $room_id;
        $guest->guest_id = $cookie_val;
        if($user_id != null){
            $guest->user_id = $user_id;
        }
        $guest->save();
        return $guest;
    }

    function roundsWonPerPlayer($room, $guest_id = null){
        $guests = $this->groupBy($room, "guest_id");
        foreach($guests as $key => &$guest){
            $won = 0;
            $points = 0;
            $alias = "";
            foreach($guest as $round){
                $points += $round->points;
                if($round->points == 0){
                    $won++;
                }
                $alias = $round->alias;
            }
            $guest = array();
            $guest['won'] = $won;
            $guest['alias'] = $alias;
            $guest['guest_id'] = $key;
            $guest['points'] = $points;
        }
        return $guests;
    }

    function groupBy($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }
}
