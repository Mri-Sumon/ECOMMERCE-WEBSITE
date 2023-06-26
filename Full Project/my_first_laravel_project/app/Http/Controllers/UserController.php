<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('backend.user.index', compact('users'));
    }

    public function roleList()
    {
        $roles = Role::latest()->paginate(10);
        return view('backend.role.index', compact('roles'));
    }

    public function usersList(Role $role)
    {
        //$roles = Role::latest()->paginate(10);
        //web.php থেকে role এর মাধ্যেমে এখানে যে id আসবে, সেই id খুজে আনবো role.php তে আমরা যে users() মেথড বানিয়েছি সেখান থেকে।
        $users = $role->users;
        //dd($users);
        return view('backend.role.show', compact('users'));
    }
}
