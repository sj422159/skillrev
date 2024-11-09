<?php

namespace App\Exports;

use App\Models\foodfeedback;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class feedbackExport implements FromCollection,WithHeadings
{
    protected $aid;

    function __construct($aid) {
        $this->aid = $aid;
    }

    public function collection(){

        return  foodfeedback::join('vendors','foodfeedbacks.catererid','vendors.id')
                ->join('hostels','foodfeedbacks.hostelid','hostels.id')
                ->join('students','foodfeedbacks.stu_id','students.id')
                ->where('foodfeedbacks.aid',$this->aid)
                ->select('hostels.hostel','vendors.fname','students.sname','foodfeedbacks.date','foodfeedbacks.quantity','foodfeedbacks.quality','foodfeedbacks.taste')
                ->get();
    }

    public function headings(): array
    {
        return [
            'Hostel',
            'Caterer',
            'Student',
            'Date',
            'Quantity',
            'Quality',
            'Taste' 
        ];
    }
}
