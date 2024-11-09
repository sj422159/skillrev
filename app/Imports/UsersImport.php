<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\ExpenseItem; // Replace with your model if needed

class UsersImport implements ToModel
{
    public function model(array $row)
    {
        // You can modify this to import data into a model
        return new ExpenseItem([
            'group' => $row['group'],
            'category' => $row['category'],
            'subcategory' => $row['subcategory'],
            'items' => $row['items'],
        ]);
    }
}
