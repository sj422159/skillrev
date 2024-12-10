<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class questionbank extends Model
{
   use HasFactory;
   protected $fillable = ['aid','skillattribute','qtype','qtext','choice1','choice2','choice3','choice4','RightChoices','qualifier1','qualifier2','qualifier3','qualifier4','difficultylevel'];
}