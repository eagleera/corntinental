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

class JuegoController extends Controller
{
    public function createNuevo(Request $request)
    {
        $data= $request->validate([
            'alias' => 'sometimes',
            'room_name' => 'required|string'
        ]);
        $room = new Room;
        $room->password = substr(str_shuffle("0123456789"), 0, 5);
        $room->status = true;
        $room->name = $data['room_name'];
        $room->save();
        $guest = $this->createGuest($room->id, $data['alias']);
        $room->owner_id = $guest->id;
        $room->save();
        $room->guest_key = $guest->guest_id;
        return $room;
    }
    public function index(Request $request, $room_id){
        $user = auth()->user();
        if(!$user){
            abort(404);
        }
        $room = Room::with('guests', 'points', 'owner')->find($room_id);
        return $room;
    }
    public function indexAvailable(){
        return Room::where('status', 1)->get();
    }

    public function indexCreate(Request $request){
        $cookie = $request->cookie('guest_id');
        if($cookie){
            $room_id = Guest::where('guest_id', $cookie)->first()->room_id;
            return redirect()->action(
                'JuegoController@index', ['id' => $room_id]
            );
        }
        return view('create_room');
    }
    public function indexJoin(Request $request){
        $cookie = $request->cookie('guest_id');
        if($cookie){
            $room_id = Guest::where('guest_id', $cookie)->first()->room_id;
            return redirect()->action(
                'JuegoController@index', ['id' => $room_id]
            );
        }
        $rooms = Room::where('status', 1)->get()->pluck('id');
        return view('join_room')->with('rooms', $rooms);
    }

    public function joinRoom(Request $request){
        $data= $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'password' => 'required|max:5',
            'alias' => 'sometimes',
            'user_id' => 'sometimes|exists:users,id',
        ]);
        $room = Room::where(['id' => $data['room_id'], 'password' => $data['password']])->first();
        if(!$room){
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
        broadcast(new JoinEvent($room->id, $room))->toOthers();
        return Room::with('points', 'guests', 'owner')->find($room_id);
    }

    public function record(Request $request){
        $user = auth()->user();
        if(!$user){
            abort(404);
        }
        $games = Guest::where('user_id', $user->getKey())->with('room', 'points')->get();
        $reponse = [];
        $response['user'] = $user;
        $response['record'] = $games;
        return $response;
    }
    public function getRounds(){
        return Round::all();
    }

    function createGuest($room_id, $alias, $user_id = null){
        $cookie_val = md5($_SERVER['REMOTE_ADDR'] . time());
        $guest = new Guest;
        $guest->alias = $alias;
        $guest->room_id = $room_id;
        $guest->guest_id = $cookie_val;
        if($user_id){
            $guest->user_id = $user_id;
        }
        $guest->save();
        return $guest;
    }
}