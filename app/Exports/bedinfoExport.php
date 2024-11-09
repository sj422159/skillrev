<?php

namespace App\Exports;

use App\Models\hostelitems;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class bedinfoExport implements FromCollection,WithHeadings
{
    protected $id;

    function __construct($id) {
        $this->id = $id;
    }

    public function collection(){

        return hostelitems::join('hostels','hostelitems.hostelid','hostels.id')
                        ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                        ->join('infraitems','hostelitems.itemid','infraitems.id')
                        ->join('students','hostelitems.stu_id','students.id')
                        ->join('categories','students.sclassid','categories.id')
                        ->join('lmssections','students.ssectionid','lmssections.id')
                        ->where('hostelitems.mid',$this->id)
                        ->where('hostelitems.itemid',2)
                        ->select('hostels.hostel','hostelrooms.roomname','hostelitems.itemno','students.sname','students.snumber','categories.categories','lmssections.section')
                        ->get();
    }

    public function headings(): array
    {
        return [
            'Hostel',
            'Room Name',
            'Bed No',
            'Student Name',
            'Student Number',
            'Class',
            'Section'
        ];
    }
}
