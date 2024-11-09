<?php

namespace App\Exports;

use App\Models\student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class studentcurrentyearpendingfeesExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($class,$section) {
        $this->class=$class; 
        $this->section=$section;     
    }

    public function collection(){
            return student::join('feepayments','feepayments.sid','students.id')
                            ->join('categories','categories.id','students.sclassid')
                            ->join('lmssections','lmssections.id','students.ssectionid')
                            ->where('sclassid',$this->class)
                            ->where('ssectionid',$this->section)
                            ->select('sregistrationnumber','students.sname','students.sfathername','categories.categories','lmssections.section','feepayments.exportmonth','feepayments.feetotal','feepayments.feetotalpaid','feepayments.exportpendingmoney')
                            ->get();
    }

    public function headings(): array{
        return [
            'Rgd. No',
            'Student',
            'Father',
            'Class',
            'Section',
            'Month',
            'Total Fees',
            'Paid Fees',
            'Pending Fees',
        ];
    }
}
