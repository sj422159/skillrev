<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class distance extends Model
{
    use HasFactory;
    protected $fillable = ['aid','COntroller_ID','busrouteid','location','distance','disstatus'];
}
