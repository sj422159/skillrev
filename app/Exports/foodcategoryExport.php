<?php

namespace App\Exports;

use App\Models\foodcategories;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class foodcategoryExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($mid) {
        $this->mid=$mid;     
    }

    public function collection(){
        return foodcategories::where('mid',$this->mid)->select('foodcategory')->get();
    }

    public function headings(): array{
        return [
            'Food Category',
        ];
    }
}
