<?php

namespace App\Exports;

use App\Models\student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class studentpendingfeesExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($class,$section) {
        $this->class=$class; 
        $this->section=$section;     
    }

    public function collection(){
            return student::join('feependings','feependings.sid','students.id')
            ->where('students.sclassid',$this->class)
            ->where('students.ssectionid',$this->section)
            ->select('students.sregistrationnumber','students.sname','students.semail','students.snumber','feependings.feetobepaid','feependings.feepaid','feependings.feebalance','feependings.feepaymentdate')
            ->get();
    }

    public function headings(): array{
        return [
            'Registration Number',
            'Name',
            'Email',
            'Number',
            'Total Fee',
            'Paid Fee',
            'Balance Fee',
            'Payment Date',
        ];
    }
}
