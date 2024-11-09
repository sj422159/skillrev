<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cafeteriaItems extends Model
{
    use HasFactory;
    protected $fillable = ['aid','mid','cafetype','cafeid','itemid','itemcode','itemno','itemdesc'];
}
