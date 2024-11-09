<?php

namespace App\Imports;

use App\Models\othersItems;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class othersitemsImport implements ToModel ,WithStartRow
{
    public function  __construct($roomid,$itemid,$aid,$mid){
        $this->aid= $aid;
        $this->mid=$mid;
        $this->roomid=$roomid;
        $this->itemid=$itemid;
      

    }

    public function startRow(): int
    {
        return 2;
    }
    
    public function model(array $row)
    {
        return new othersItems([
            'aid'=>$this->aid,
            'mid'=>$this->mid,
            'roomid'=>$this->roomid,
            'itemid'=>$this->itemid,
            'itemcode'  => (String) $row[0],
            'itemno'   => (String) $row[1],
            'itemdesc'   => (String) $row[2],
           

        ]);
    }
}
