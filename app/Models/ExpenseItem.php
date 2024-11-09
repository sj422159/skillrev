<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseItem extends Model
{
    use HasFactory;
    protected $table = 'expenseitems'; 
    protected $fillable = [
        'group',
        'category',
        'subcategory',
        'items',
    ];

    // Fetch unique group names
    public static function getUniqueGroups()
    {
        return self::select('group')->distinct()->get();
    }

    // Fetch unique categories for a specific group
    public static function getUniqueCategories($group)
    {
        return self::where('group', $group)->select('category')->distinct()->get();
    }

    // Fetch unique subcategories for a specific category
    public static function getUniqueSubcategories($group, $category)
    {
        return self::where('group', $group)
                    ->where('category', $category)
                    ->select('subcategory')
                    ->distinct()
                    ->get();
    }
}

