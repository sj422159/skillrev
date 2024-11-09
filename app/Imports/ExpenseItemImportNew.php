<?php

namespace App\Imports;

use App\Models\ExpenseItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExpenseItemImportNew implements ToModel, WithHeadingRow, WithValidation
{
    protected $controller_id;


    public function model(array $row)
    {
        // Check if the row has exactly 4 columns to avoid issues
        if (count($row) < 4) {
            throw new \Exception("Incorrect file format. Each row should have exactly 4 columns. Row content: " . implode(", ", $row));
        }

        return DB::table('expenseitems')->insert([
            'group' => $row['group'],
            'category' => $row['category'],
            'subcategory' => $row['subcategory'],
            'items' => $row['items'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.group' => 'required|string',
            '*.category' => 'required|string',
            '*.subcategory' => 'required|string',
            '*.items' => 'required|string',
        ];
    }
}
