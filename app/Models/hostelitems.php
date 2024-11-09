<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hostelitems extends Model
{
    use HasFactory;
    protected $fillable = ['aid','mid','hostelid','roomid','itemid','itemcode','itemno','itemdesc'];
}
