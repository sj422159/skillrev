<?php

namespace App\Exports;

use App\Models\student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class supervisorstudentlistExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($classid,$sectionid) {
        $this->aid=session()->get('SUPERVISOR_ADMIN_ID'); 
        $this->classid=$classid; 
        $this->sectionid=$sectionid;     
    }

    public function collection(){
            return  student::where('aid',$this->aid)
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
