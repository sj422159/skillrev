<?php

namespace App\Exports;

use App\Models\nontechsupervisor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class nontechgroupmanagerdataExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($adminid) {
        $this->adminid=$adminid;     
    }

    public function collection(){
        return nontechsupervisor::where('aid',$this->adminid)->select('nontechsupervisors.supname','nontechsupervisors.supemail','nontechsupervisors.supnumber')->get();
    }

    public function headings(): array{
        return [
            'Name',
            'Number',
            'Email',
        ];
    }
}
