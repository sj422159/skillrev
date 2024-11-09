<?php

namespace App\Exports;

use App\Models\nontechstaff;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class nontechstaffdataExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($adminid) {
        $this->adminid=$adminid;     
    }

    public function collection(){
        return nontechstaff::where('aid',$this->adminid)->select('nontechstaffs.fname','nontechstaffs.femail','nontechstaffs.fnumber')->get();
    }

    public function headings(): array{
        return [
            'Name',
            'Number',
            'Email',
        ];
    }
}
