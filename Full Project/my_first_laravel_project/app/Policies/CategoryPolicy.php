<?php

namespace App\Policies;

use App\Models\User;

class CategoryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    //create নামে একটি ফাংশন ক্রিয়েট করে সেখানে User Table কে কল করবো।
    public function create(User $user){
        if (auth()->user()->role_id==2){
            return true;
        }else{
            return false;
        }
    }
}
