<?php

namespace App\Exports;

use App\Models\fooditems;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class itemsExport implements FromCollection,WithHeadings
{
    protected $aid;
    protected $mid;

    function __construct($aid,$mid) {
        $this->aid = $aid;
        $this->mid = $mid;
    }

    public function collection(){

        return  fooditems::join('foodcategories','fooditems.foodcat','foodcategories.id')
                ->join('foodpricetypes','fooditems.pricetype','foodpricetypes.id')
                ->where('fooditems.aid',$this->aid)
                ->where('fooditems.mid',$this->mid)
                ->select('foodcategories.foodcategory','fooditems.fooditems','fooditems.pricetype','fooditems.price')
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
