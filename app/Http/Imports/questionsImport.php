<?php

namespace App\Imports;

use App\Models\questionbank;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class questionsImport implements ToModel ,WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function  __construct($skill_attr,$aid)
    {
        $this->skill_attr= $skill_attr;
        $this->aid= $aid;
    }

    public function startRow(): int
    {
        return 2;
    }
    
    public function model(array $row)
    {
        return new questionbank([
            'aid'=>$this->aid,
            'skillattribute'=>$this->skill_attr,
            'qtype'  => (String) $row[0],
            'qtext'   => (String) $row[1],
            'choice1'   => (String) $row[2],
            'choice2'    => (String) $row[3],
            'choice3'  => (String) $row[4],
            'choice4'   => (String) $row[5],
            'RightChoices'   => (String) $row[6],
            'difficultylevel'   => (String) $row[7],
        ]);
    }
}
