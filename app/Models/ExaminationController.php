<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ExaminationController extends Authenticatable
{
     // Specify the table name (if it's different from the default 'academic_controllers')
     protected $table = 'examination_controller';

     // Fillable fields
     protected $fillable = ['name', 'email', 'password'];
 
     // Hidden fields to protect sensitive data
     protected $hidden = ['password', 'remember_token'];
 
     // Other model logic if needed
}
