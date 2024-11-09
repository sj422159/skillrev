<?php

namespace App\Exports;

use App\Models\supervisor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class groupmanagerdataExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($adminid) {
        $this->adminid=$adminid;     
    }

    public function collection(){
        return supervisor::where('aid',$this->adminid)->select('supervisors.supname','supervisors.supemail','supervisors.supnumber')->get();
    }

    public function headings(): array{
        return [
            'Name',
            'Number',
            'Email',
        ];
    }
}
