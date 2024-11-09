<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class schoolitems extends Model
{
   use HasFactory;
    protected $fillable = ['aid','mid','classid','sectionid','itemid','itemcode','itemno','itemdesc','facid'];
}
