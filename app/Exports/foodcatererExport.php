<?php

namespace App\Exports;

use App\Models\vendors;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class foodcatererExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($mid) {
        $this->mid=$mid;     
    }

    public function collection(){
        return  vendors::join('cafeteriatype','vendors.cafeteriatype','cafeteriatype.id')
                ->where('mid',$this->mid)
                ->select('cafeteriatype.ctype','vendors.fname','vendors.email','vendors.mobile')
                ->get();
    }

    public function headings(): array{
        return [
            'Cafeteria Type',
            'Name',
            'Email',
            'Number'
        ];
    }
}
