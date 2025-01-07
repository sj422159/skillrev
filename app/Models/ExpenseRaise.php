<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseRaise extends Model
{
    use HasFactory;

    protected $table = 'exp_raise'; // Ensure this matches your actual table name

    protected $fillable = [
        'aid',
        'nontechmanagerid',
        'groupid',
        'categoryid',
        'subcatid',
        'itemid', // Comma-separated item IDs
        'quantity_measure',
        'quantity',
        'status',
    ];

    // Default value for status
    protected $attributes = [
        'status' => '0',
    ];

    // Define relationships
    public function group()
    {
        return $this->belongsTo(expenses::class, 'groupid', 'id');
    }

    public function category()
    {
        return $this->belongsTo(expense_cat::class, 'categoryid', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(expense_subcat::class, 'subcatid', 'id');
    }

    // Custom method to get related ExpenseItems
    // Add this relationship method
    public function item()
    {
    return $this->belongsTo(ExpenseItem::class, 'itemid', 'id');
    }

// Keep your existing getItemsAttribute() for handling multiple items
    public function getItemsAttribute()
    {
    $itemIds = explode(',', $this->itemid);
    return ExpenseItem::whereIn('id', $itemIds)->get();
    }
}
