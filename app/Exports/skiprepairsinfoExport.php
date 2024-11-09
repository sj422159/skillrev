<?php

namespace App\Exports;

use App\Models\skipmeals;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class skiprepairsinfoExport implements FromCollection,WithHeadings
{
    protected $id;

    function __construct($id) {
        $this->id = $id;
    }

    public function collection(){
        return  skipmeals::join('hostels','skipmeals.hostelid','hostels.id')
                    ->join('foodcategories','skipmeals.catid','foodcategories.id')
                    ->join('students','skipmeals.stu_id','students.id')
                    ->where('hostels.aid',$this->id)
                    ->select('students.sname','hostels.hostel','foodcategories.foodcategory','skipmeals.skipday')
                    ->get();
    }

    public function headings(): array
    {
        return [
            'Student Name',
            'Hostel',
            'Food Category',
            'Date',  
        ];
    }
}
