<?php

namespace App\Imports;

use App\Models\ExpenseItem;
use Maatwebsite\Excel\Concerns\ToModel;

class ExpenseItemsImport implements ToModel
{
    public function model(array $row)
    {
        return new ExpenseItem([
            'group' => $row[0],
            'category' => $row[1],
            'subcategory' => $row[2],
            'items' => $row[3],
        ]);
    }
}
