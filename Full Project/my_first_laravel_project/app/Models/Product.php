<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{                   
    // SoftDeletes Trade use for RecyfleBin
    use HasFactory, SoftDeletes;
    
    //নিচের কোডের মাধ্যমে ফর্মের সকল ডাটা ডাটাবেসে যাবে।
    protected $guarded = ['id'];
}
