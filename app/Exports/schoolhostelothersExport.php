<?php

namespace App\Exports;

use App\Models\cafeteriaItems;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class schoolhostelothersExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($type,$aid) {
        $this->type=$type;   
        $this->aid=$aid;     
    }

    public function collection(){
        return  cafeteriaItems::join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                ->where('cafeteria_items.aid',$this->aid)
                ->where('cafetype',$this->type)
                ->select('cafeterias.cafeteria','infraitems.infraitem','cafeteria_items.itemno','cafeteria_items.itemdesc')
                ->get();
    }

    public function headings(): array{
        return [
            'Cafeteria', 
            'Items',
            'Item No',  
            'Item Desc' 
        ];
    }
}
