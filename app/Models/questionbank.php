<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class questionbank extends Model
{
    protected $fillable = [
        'aid', 
        'Controller_ID', // Add Controller_ID here
        'Controller_ADMIN_ID', 
        'skillattribute', 
        'qtype', 
        'qtext', 
        'choice1', 
        'choice2', 
        'choice3', 
        'choice4', 
        'RightChoices', 
        'difficultylevel'
    ];
}
