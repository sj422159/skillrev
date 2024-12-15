<?php

namespace App\Imports;

use App\Models\distance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class distanceImport implements ToModel ,WithStartRow
{
    public function  __construct($aid,$busrouteid){
        $this->aid= $aid;
        $this->busrouteid= $busrouteid;
    }

    public function startRow(): int
    {
        return 2;
    }
    
    public function model(array $row)
    {
        return new distance([
            'aid'=>$this->aid,
            'busrouteid'=>$this->busrouteid,
            'location'   => (String) $row[0],
            'distance'   => (String) $row[1],
            'disstatus'   => 1,
        ]);
    }
}
