<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assesments extends Model
{
    protected $fillable = [
        'ass_id', 'sectionname', 'sectionduration', 'sectionpass', 'domain', 'skillset',
        'skillattrs', 'noofquestions', 'category', 'totalquestions', 'level', 'time',
        'controller_id', 'aid'
    ];
}
