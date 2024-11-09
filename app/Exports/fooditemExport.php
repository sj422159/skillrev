<?php

namespace App\Exports;

use App\Models\fooditems;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class fooditemExport implements FromCollection,WithHeadings
{
    protected $mid;

    function __construct($mid) {
        $this->mid = $mid;
    }

    public function collection(){

        return  fooditems::join('foodcategories','fooditems.foodcat','foodcategories.id')
                ->join('foodpricetypes','fooditems.pricetype','foodpricetypes.id')
                ->where('fooditems.mid',$this->mid)
                ->select('foodcategories.foodcategory','fooditems.fooditems','foodpricetypes.ptype','fooditems.price')
                ->get();
    }

    public function headings(): array
    {
        return [
            'Food Category',
            'Food Items',
            'Price Type',
            'Price',
        ];
    }
}
