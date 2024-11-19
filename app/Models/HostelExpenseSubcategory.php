<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostelExpenseSubcategory extends Model
{
    use HasFactory;

    protected $table = 'hostelexp_subcat';

    protected $fillable = [
        'group',
        'category',
        'subcategory',
        'nontechm_id'
    ];
}
