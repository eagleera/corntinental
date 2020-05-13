<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Providers\RouteServiceProvider;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('admin', 0)->orderBy('id', 'DESC')->get();
        return view('admin')->with('users', $users);
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
