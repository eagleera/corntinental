<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Guest;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $cookie = $request->cookie('guest_id');
        if($cookie){
            $room_id = Guest::where('guest_id', $cookie)->first()->room_id;
            return redirect()->action(
                'JuegoController@index', ['id' => $room_id]
            );
        }
        return view('welcome');
    }
}
