<?php

namespace App\Exports;

use App\Models\vendors;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class catererExport implements FromCollection,WithHeadings
{
    protected $aid;
    protected $mid;

    function __construct($aid,$mid) {
        $this->aid = $aid;
        $this->mid = $mid;
    }

    public function collection(){

        return  vendors::join('cafeteriatype','vendors.cafeteriatype','cafeteriatype.id')
                ->where('aid',$this->aid)
                ->where('mid',$this->mid)
                ->select('cafeteriatype.ctype','vendors.fname','vendors.lname','vendors.mobile','vendors.email')
                ->get();
    }

    public function headings(): array
    {
        return [
            'Cafeteria Type',
            'First Name',
            'Last Name',
            'Mobile',
            'Email'
        ];
    }
}