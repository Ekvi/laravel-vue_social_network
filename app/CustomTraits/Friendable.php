<?php

namespace App\CustomTraits;

use App\Friendship;
use App\User;

trait Friendable
{
    public function addFriend($user_requested_id)
    {
        if($this->id === $user_requested_id ) {
            return 0;
        }

        if($this->hasPendingFriendRequestSentTo($user_requested_id) === 1) {
            return "already sent a friend request";
        }

        if($this->hasPendingFriendsRequestFrom($user_requested_id) === 1) {
            return $this->acceptFriend($user_requested_id);
        }

        $friendship = Friendship::create([
            'requester' => $this->id,
            'user_requested' => $user_requested_id
        ]);

        if($friendship) {
            return 1;
        }

        return 0;
    }

    public function acceptFriend($requester)
    {
        if($this->hasPendingFriendsRequestFrom($requester) === 0) {
            return 0;
        }

        $friendship = Friendship::where('requester', $requester)
                                ->where('user_requested' , $this->id)
                                ->first();

        if($friendship) {
            $friendship->update([
                'status' => 1
            ]);

            return 1;
        }

        return 0;
    }

    public function friends()
    {
        $friends1 = [];

        $f1 = Friendship::where('status', 1)->where('requester', $this->id)->get();

        foreach($f1 as $friendship) {
            array_push($friends1, User::find($friendship->user_requested));
        }

        $friends2 = [];
        $f2 = Friendship::where('status', 1)->where('user_requested', $this->id)->get();

        foreach($f2 as $friendship) {
            array_push($friends2, User::find($friendship->requester));
        }

        return array_merge($friends1, $friends2);
    }

    public function pendingFriendRequests()
    {
        $users = [];

        $friendships = Friendship::where('status', 0)->where('user_requested', $this->id)->get();

        foreach($friendships as $friendship) {
            array_push($users, User::find($friendship->requester));
        }

        return $users;
    }

    public function friendsIds()
    {
        return collect($this->friends())->pluck('id');
    }

    public function isFriendsWith($userId)
    {
        if(in_array($userId, $this->friendsIds()->toArray())) {
            return 1;
        } else {
            return 0;
        }
    }

    public function pendingFriendRequestsIds()
    {
        return collect($this->pendingFriendRequests())->pluck('id')->toArray();
    }

    public function pendingFriendRequestsSent()
    {
        $users = array();

        $friendships = Friendship::where('status', 0)->where('requester', $this->id)->get();

        foreach($friendships as $friendship) {
            array_push($users, User::find($friendship->user_requested));
        }

        return $users;
    }

    public function pendingFriendRequestSentIds()
    {
        return collect($this->pendingFriendRequestsSent())->pluck('id')->toArray();
    }

    public function hasPendingFriendsRequestFrom($userId)
    {
        if(in_array($userId, $this->pendingFriendRequestsIds())) {
            return 1;
        } else {
            return 0;
        }
    }

    public function hasPendingFriendRequestSentTo($userId)
    {
        if(in_array($userId, $this->pendingFriendRequestSentIds())) {
            return 1;
        } else {
            return 0;
        }
    }
}