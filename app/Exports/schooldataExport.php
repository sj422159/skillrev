<?php

namespace App\Exports;

use App\Models\schoolitems;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class schooldataExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($mid) {
        $this->mid=$mid;     
    }

    public function collection(){
        return  schoolitems::join('categories','schoolitems.classid','categories.id')
                ->join('lmssections','schoolitems.sectionid','lmssections.id')
                ->join('infraitems','schoolitems.itemid','infraitems.id')
                ->where('schoolitems.mid',$this->mid)
                ->select('categories.categories','lmssections.section','infraitems.infraitem','schoolitems.itemno','schoolitems.itemdesc')
                ->get();
    }

    public function headings(): array{
        return [
            'Hostel',
            'Room Name',
            'Items',
            'Item No',  
            'Item Desc',    
        ];
    }
}
