<?php

namespace App\Exports;

use App\Models\nontechmanager;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class nontechmanagerdataExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($adminid) {
        $this->adminid=$adminid;     
    }

    public function collection(){
        return nontechmanager::where('aid',$this->adminid)->select('nontechmanagers.mname','nontechmanagers.memail','nontechmanagers.mnumber')->get();
    }

    public function headings(): array{
        return [
            'Name',
            'Number',
            'Email',
        ];
    }
}
