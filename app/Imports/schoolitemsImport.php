<?php

namespace App\Imports;

use App\Models\schoolitems;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class schoolitemsImport implements ToModel ,WithStartRow
{
    public function  __construct($hostelid,$roomid,$itemid,$aid,$mid,$facid){
        $this->aid= $aid;
        $this->mid=$mid;
        $this->hostelid=$hostelid;
        $this->roomid=$roomid;
        $this->itemid=$itemid;
        $this->facid=$facid;

    }

    public function startRow(): int
    {
        return 2;
    }
    
    public function model(array $row)
    {
        return new schoolitems([
            'aid'=>$this->aid,
            'mid'=>$this->mid,
            'classid'=>$this->hostelid,
            'sectionid'=>$this->roomid,
            'itemid'=>$this->itemid,
            'itemcode'  => (String) $row[0],
            'itemno'   => (String) $row[1],
            'itemdesc'   => (String) $row[2],
            'facid' => $this->facid,

        ]);
    }
}
