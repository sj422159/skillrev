<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseItem extends Model
{
    use HasFactory;

    protected $table = 'expense_item'; // Ensure this matches your table name

    protected $fillable = [
        'aid', 
        'nontechmanagerid', 
        'groupid', 
        'categoryid', 
        'subcatid', 
        'item', 
        'quantity'
    ];

    // Define relationships
    public function group()
    {
        return $this->belongsTo(expenses::class, 'groupid', 'id'); // Ensure 'id' is correct
    }

    public function category()
    {
        return $this->belongsTo(expense_cat::class, 'categoryid', 'id'); // Ensure 'id' is correct
    }

    public function subcategory()
    {
        return $this->belongsTo(expense_subcat::class, 'subcatid', 'id'); // Ensure 'id' is correct
    }

    // Accessors to get related model names (with null checks)
    public function getGroupNameAttribute()
    {
        return $this->group ? $this->group->Group : null; // Access the group name from the related `expenses` model
    }

    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->Category : null; // Access the category name from the related `expense_cat` model
    }

    public function getSubcategoryNameAttribute()
    {
        return $this->subcategory ? $this->subcategory->subcategory : null; // Access the subcategory name from the related `expense_subcat` model
    }
}
