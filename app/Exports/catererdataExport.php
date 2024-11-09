<?php

namespace App\Exports;

use App\Models\vendors;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class catererdataExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($adminid) {
        $this->adminid=$adminid;     
    }

    public function collection(){
        return vendors::where('aid',$this->adminid)->where('role',1)->select('fname','email','mobile')->get();
    }

    public function headings(): array{
        return [
            'Name',
            'Email',
            'Number'
        ];
    }
}
