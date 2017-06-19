<?php

namespace App\Http\Controllers;

use App\Notifications\FriendRequestAccepted;
use App\Notifications\NewFriendRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendShipController extends Controller
{
    public function check($id)
    {
        if(Auth::user()->isFriendsWith($id)) {
            return ['status' => 'friends'];
        }

        if(Auth::user()->hasPendingFriendsRequestFrom($id)) {
            return ['status' => 'pending'];
        }

        if(Auth::user()->hasPendingFriendRequestSentTo($id)) {
            return ['status' => 'waiting'];
        }

        return ['status' => 0];
    }

    public function addFriend($id)
    {
        $resp = Auth::user()->addFriend($id);

        User::find($id)->notify(new NewFriendRequest(Auth::user()));

        return $resp;
    }

    public function acceptFriend($id)
    {
        $resp = Auth::user()->acceptFriend($id);

        User::find($id)->notify(new FriendRequestAccepted(Auth::user()));

        return $resp;
    }
}

