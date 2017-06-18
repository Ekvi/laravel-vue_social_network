<?php

namespace App\Http\Controllers;

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
        return Auth::user()->addFriend($id);
    }

    public function acceptFriend($id)
    {
        return Auth::user()->acceptFriend($id);
    }
}

