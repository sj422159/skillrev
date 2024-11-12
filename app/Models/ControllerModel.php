<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControllerModel extends Model
{
    use HasFactory;

    protected $table = 'controller';

    protected $fillable = [
        'name', 
        'Controller_role_id', 
        'role', 
        'email', 
        'password', 
        'number',
        'aid', // Make sure 'aid' is fillable as well
    ];

    // Define the relationship with Expense
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
