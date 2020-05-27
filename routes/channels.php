<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('joinChannel', function () {
    return true; //Always return true or false
});
Broadcast::channel('closeChannel', function () {
    return true; //Always return true or false
});
Broadcast::channel('pointsChannel', function () {
    return true; //Always return true or false
});