<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseRaise extends Model
{
    protected $table = 'exp_raise'; // Make sure this matches your table name

    protected $fillable = [
        'aid',
        'nontechmanagerid',
        'groupid',
        'categoryid',
        'subcatid',
        'itemid',
        'quantity_measure',
        'quantity',
        'status',
        ];
    
        // Set default values for attributes
        protected $attributes = [
            'status' => '0', 
    ];

    // Define the relationships
    public function group()
    {
        return $this->belongsTo(expenses::class, 'groupid');
    }

    public function category()
    {
        return $this->belongsTo(expense_cat::class, 'categoryid');
    }

    public function subcategory()
    {
        return $this->belongsTo(expense_subcat::class, 'subcatid');
    }

    public function item()
    {
        return $this->belongsTo(ExpenseItem::class, 'itemid');
    }
}

