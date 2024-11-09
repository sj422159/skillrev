<?php

namespace App\Exports;

use App\Models\hostelitems;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class hosteldataExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($mid) {
        $this->mid=$mid;     
    }

    public function collection(){
        return  hostelitems::join('hostels','hostelitems.hostelid','hostels.id')
                ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                ->join('infraitems','hostelitems.itemid','infraitems.id')
                ->where('hostelitems.mid',$this->mid)
                ->select('hostels.hostel','hostelrooms.roomname','infraitems.infraitem','hostelitems.itemno','hostelitems.itemdesc')
                ->get();
    }

    public function headings(): array{
        return [
            'Hostel',
            'Room Name',
            'Items',
            'Item No',  
            'Item Desc',    
        ];
    }
}
