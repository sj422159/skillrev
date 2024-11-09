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
        'role', 
        'email', 
        'password',
        'number',
    ];

    // In your Controller model (e.g., Controller.php)
public function expenses()
{
    return $this->hasMany(Expense::class);
}

}
