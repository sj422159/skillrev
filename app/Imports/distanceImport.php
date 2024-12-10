<?php

namespace App\Imports;

use App\Models\distance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class distanceImport implements ToModel ,WithStartRow
{
    public function  __construct($Controller_ADMIN_ID,$busrouteid,$Controller_ID){
        $this->aid= $Controller_ADMIN_ID;
        $this->busrouteid= $busrouteid;
        $this->Controller_ID= $Controller_ID;
    }

    public function startRow(): int
    {
        return 3;
    }
    
    public function model(array $row)
    {
        return new distance([
            'aid'=>$this->aid,
            'Controller_ID'=>$this->Controller_ID,
            'busrouteid'=>$this->busrouteid,
            'location'   => (String) $row[0],
            'distance'   => (String) $row[1],
            'disstatus'   => 1,
        ]);
    }
}
