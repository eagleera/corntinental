<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Room;
use App\Guest;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Cookie;

class JuegoController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createNuevo(Request $request)
    {
        $data= $request->validate([
            'alias' => 'sometimes'
        ]);
        $room = new Room;
        $room->password = substr(str_shuffle("0123456789"), 0, 5);
        $room->status = true;
        $room->save();
        $guest = $this->createGuest($room->id, $data['alias']);
        $cookie = cookie('guest_id', $guest->guest_id, 600);
        $room->owner_id = $guest->id;
        $room->save();
        return redirect()->action(
            'JuegoController@index', ['id' => $room->id]
        )->cookie($cookie);
    }
    public function index(Request $request, $room_id){
        $room = Room::with('guests')->find($room_id);
        $cookie = $request->cookie('guest_id');
        $me = Guest::where('guest_id', $cookie)->first();
        return view('room')->with('room', $room)->with('me', $me);
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
            'alias' => 'sometimes'
        ]);
        $room = Room::where(['id' => $data['room_id'], 'password' => $data['password']])->first();
        if(!$room){
            return \Redirect::back()->withErrors(['La contraseña no coincide']);
        }
        $guest = $this->createGuest($room->id, $data['alias']);
        $cookie = cookie('guest_id', $guest->guest_id, 600);
        return redirect()->action(
            'JuegoController@index', ['id' => $room->id]
        )->cookie($cookie);
    }

    function createGuest($room_id, $alias){
        $cookie_val = md5($_SERVER['REMOTE_ADDR'] . time());
        $guest = new Guest;
        $guest->alias = $alias;
        $guest->room_id = $room_id;
        $guest->guest_id = $cookie_val;
        $guest->save();
        return $guest;
    }

    public function editUser($user_id){
        $user = User::find($user_id);
        return view('edit_user')->with('user', $user);
    }
    public function handleEditUser(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $user = User::find($id);
        $user->name = $name;
        $user->email = $email;
        $user->save();
        return redirect(RouteServiceProvider::ADMIN);
    }
    public function deleteUser($id){
        User::destroy($id);
        return redirect(RouteServiceProvider::ADMIN);
    }
}