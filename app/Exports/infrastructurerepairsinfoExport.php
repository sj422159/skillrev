<?php

namespace App\Exports;

use App\Models\hostelinfrarepairhistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class infrastructurerepairsinfoExport implements FromCollection,WithHeadings
{
    protected $id;

    function __construct($id) {
        $this->id = $id;
    }

    public function collection(){
        return  hostelinfrarepairhistory::join('hostels','hostelinfrarepairhistories.hostelid','hostels.id')
                    ->join('hostelrooms','hostelinfrarepairhistories.roomid','hostelrooms.id')
                    ->join('infraitems','hostelinfrarepairhistories.itemid','infraitems.id')
                    ->where('hostelinfrarepairhistories.mid',$this->id)
                    ->select('hostels.hostel','hostelrooms.roomname','infraitems.infraitem','hostelinfrarepairhistories.itemno','hostelinfrarepairhistories.repairissued','hostelinfrarepairhistories.workstarted','hostelinfrarepairhistories.repairfinished')
                    ->get(); 
    }

    public function headings(): array
    {
        return [
            'Hostel',
            'Room Name',
            'Items',
            'Item No',  
            'Repair Issued',
            'Repairwork Started',
            'Repairwork Finished'
        ];
    }
}
