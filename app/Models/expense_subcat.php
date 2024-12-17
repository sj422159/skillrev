<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expense_subcat extends Model
{
    use HasFactory;
    public function group()
{
    return $this->belongsTo(expenses::class, 'groupid', 'id');
}

public function category()
{
    return $this->belongsTo(expense_cat::class, 'categoryid', 'id');
}
    
}
