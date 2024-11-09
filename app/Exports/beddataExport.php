<?php

namespace App\Exports;

use App\Models\hostelitems;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class beddataExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($aid) {
        $this->aid=$aid;     
    }

    public function collection(){
        return  hostelitems::join('hostels','hostelitems.hostelid','hostels.id')
                         ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                         ->join('infraitems','hostelitems.itemid','infraitems.id')
                         ->where('hostelitems.aid',$this->aid)
                         ->where('hostelitems.itemid',2)
                         ->select('hostels.hostel','hostelrooms.roomname','hostelitems.itemno')
                         ->get();
    }

    public function headings(): array{
        return [
            'Hostel',
            'Room Name',
            'Bed No'
        ];
    }
}
