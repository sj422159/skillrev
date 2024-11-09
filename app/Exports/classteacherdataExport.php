<?php

namespace App\Exports;

use App\Models\faculty;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class classteacherdataExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($adminid) {
        $this->adminid=$adminid;     
    }

    public function collection(){
        return faculty::where('aid',$this->adminid)->where('classteacher',1)
              ->select('faculties.fname','faculties.femail','faculties.fnumber')->get();
    }

    public function headings(): array{
        return [
            'Name',
            'Number',
            'Email',
        ];
    }
}
