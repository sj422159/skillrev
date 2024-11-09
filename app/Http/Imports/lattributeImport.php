<?php

namespace App\Imports;

use App\Models\lmsoptionlist;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class lattributeImport implements ToModel ,WithStartRow
{

    public function  __construct($oid)
    {   
        $this->aid=session()->get('ADMIN_ID');
        $this->oid= $oid;
    }

     public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        return new lmsoptionlist([
                    'aid'=>$this->aid,
                    'oid'=>$this->oid,
                    'name'  => (String) $row[0],
        ]);
    }
}
