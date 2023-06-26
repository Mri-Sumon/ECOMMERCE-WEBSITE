<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    //ডাটাবেস টেবিলের সবগুলি ফিল্ডে ডাটা ফেক ডাটা যাবে।
    protected $guarded = [];

    //একটি Role এর আন্ডারে অনেক গুলি user নির্ধারন।
    public function users()
    {
        //এখানে User হল ডাটাবেস টেবিল এর নাম। User টেবিলের যেটি role_id, role টেবিলের সেটি id
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
