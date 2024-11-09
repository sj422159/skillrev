<?php

namespace App\Exports;

use App\Models\admin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class admindataExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($adminid) {
        $this->adminid=$adminid;     
    }

    public function collection(){
        return admin::where('id',$this->adminid)->select('admins.aname','admins.aemail','admins.anumber')->get();
    }

    public function headings(): array{
        return [
            'Name',
            'Number',
            'Email',
        ];
    }
}
