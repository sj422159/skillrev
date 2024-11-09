<?php

namespace App\Imports;

use App\Models\student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class studentImport implements ToModel ,WithStartRow
{
    

    public function  __construct($sec)
    {
        $this->mid=session()->get('MANAGER_ID');
        $this->sec=$sec;
        $this->aid=session()->get('MANAGER_ADMIN_ID');
        $this->classid=session()->get('MANAGER_CLASS_ID');
        $this->image="0";
        $this->status="1";
        $this->tmails="0";
    }

     public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        return new student([
                    'aid'=>$this->aid,
                    'mid'=>$this->mid,
                    'sname'=>$row[0],
                    'semail'   => $row[1],
                    'snumber'    => $row[2],
                    'sfathername'    => $row[3],
                    'sregistrationnumber'    => $row[4],
                    'password'   =>\Hash::make($row[2]),
                    'sclassid' =>$this->classid,
                    'ssectionid'=>$this->sec,
                    'image'  => $this->image,
                    'status'  => $this->status,
                    'tmails'  => $this->tmails, 
        ]);
    }
}
