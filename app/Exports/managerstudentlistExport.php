<?php

namespace App\Exports;

use App\Models\student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class managerstudentlistExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($classid,$sectionid) {
        $this->mid=session()->get('MANAGER_ID'); 
        $this->classid=$classid; 
        $this->sectionid=$sectionid;     
    }

    public function collection(){
            return  student::where('mid',$this->mid)
                    ->where('sclassid',$this->classid)
                    ->where('ssectionid',$this->sectionid)
                    ->select('sname','semail','snumber')
                    ->get();
    }

    public function headings(): array{
        return [
            'Name',
            'Email',
            'Number',
        ];
    }
}
