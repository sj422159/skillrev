<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseItem extends Model
{
    use HasFactory;

    protected $table = 'expense_item';
    
        protected $fillable = [
            'aid', 
            'nontechmanagerid', 
            'groupid', 
            'categoryid', 
            'subcatid', 
            'item', 
            'quantity'
        ];
    
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
        public function getGroupNameAttribute()
        {
            return DB::table('expenses')
                ->where('id', $this->groupid)
                ->value('Group'); 
        }
    
    
        public function getCategoryNameAttribute()
        {
            return DB::table('expense_cat')
                ->where('id', $this->categoryid)
                ->value('Category'); 
        }
    
       
        public function getSubcategoryNameAttribute()
        {
            return DB::table('expense_subcats')
                ->where('id', $this->subcatid)
                ->value('subcategory'); 
        }
    }
    

