<?php

namespace App\Imports;

use App\Models\cafeteriaItems;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class cafeteriaitemsImport implements ToModel ,WithStartRow
{
    public function  __construct($hostelid,$roomid,$itemid,$aid,$mid){
        $this->aid= $aid;
        $this->mid=$mid;
        $this->hostelid=$hostelid;
        $this->roomid=$roomid;
        $this->itemid=$itemid;
      

    }

    public function startRow(): int
    {
        return 2;
    }
    
    public function model(array $row)
    {
        return new cafeteriaItems([
            'aid'=>$this->aid,
            'mid'=>$this->mid,
            'cafetype'=>$this->hostelid,
            'cafeid'=>$this->roomid,
            'itemid'=>$this->itemid,
            'itemcode'  => (String) $row[0],
            'itemno'   => (String) $row[1],
            'itemdesc'   => (String) $row[2],
           

        ]);
    }
}
