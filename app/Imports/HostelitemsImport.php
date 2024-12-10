<?php

namespace App\Imports;

use App\Models\hostelitems;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class HostelitemsImport implements ToModel ,WithStartRow
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
        return new hostelitems([
            'aid'=>$this->aid,
            'mid'=>$this->mid,
            'hostelid'=>$this->hostelid,
            'roomid'=>$this->roomid,
            'itemid'=>$this->itemid,
            'itemcode'  => (String) $row[0],
            'itemno'   => (String) $row[1],
            'itemdesc'   => (String) $row[2],
        ]);
    }
}
