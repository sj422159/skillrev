<?php

namespace App\Imports;

use App\Models\holiday;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class holidayImport implements ToModel ,WithStartRow
{
    public function  __construct($aid){
        $this->aid= $aid;
    }

    public function startRow(): int
    {
        return 2;
    }
    
    public function model(array $row)
    {
        return new holiday([
            'aid'=>$this->aid,
            'holidayname'  => (String) $row[0],
            'date'   => (String) $row[1],
        ]);
    }
}
