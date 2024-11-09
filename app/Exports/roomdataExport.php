<?php

namespace App\Exports;

use App\Models\hostelrooms;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class roomdataExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($mid) {
        $this->mid=$mid;     
    }

    public function collection(){
        return  hostelrooms::join('hostels','hostelrooms.hostelid','hostels.id')
                ->where('mid',$this->mid)
                ->select('hostelrooms.roomname','hostels.hostel','hostelrooms.bedcapacity')
                ->get();
    }

    public function headings(): array{
        return [
            'Room',
            'Hostel Name',
            'Bed Capacity'
        ];
    }
}
