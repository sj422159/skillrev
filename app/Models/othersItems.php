<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class othersItems extends Model
{
    use HasFactory;

    protected $fillable = ['aid','mid','roomid','itemid','itemcode','itemno','itemdesc'];
}
