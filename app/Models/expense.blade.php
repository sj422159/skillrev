<?php

// Inside app/Models/Expense.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    // Define the belongsTo relationship with Controller
    public function controller()
    {
        return $this->belongsTo(Controller::class);
    }
}
