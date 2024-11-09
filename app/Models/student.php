<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    use HasFactory;
    protected $fillable = ['aid','mid','sname','sfathername','sregistrationnumber','semail','snumber','password','image','status','tmails','sclassid','ssectionid','aadharnumber'];
}
