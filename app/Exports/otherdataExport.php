<?php

namespace App\Exports;

use App\Models\othersItems;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class otherdataExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($mid) {
        $this->mid=$mid;     
    }

    public function collection(){
        return  othersItems::join('rooms','others_items.roomid','rooms.id')
                ->join('infraitems','others_items.itemid','infraitems.id')
                ->where('others_items.mid',$this->mid)
                ->select('rooms.roomname','rooms.capacity','infraitems.infraitem','others_items.itemno','others_items.itemdesc')
                ->get();
    }

    public function headings(): array{
        return [
            'Bed Name',
            'Capacity',
            'Items',
            'Item No',  
            'Item Desc',    
        ];
    }
}
