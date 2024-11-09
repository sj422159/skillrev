<?php

namespace App\Exports;

use App\Models\schoolitems;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class schoolinfoExport implements FromCollection,WithHeadings
{
    protected $id;

    function __construct($id) {
        $this->id = $id;
    }

    public function collection(){

        return schoolitems::join('categories','schoolitems.classid','categories.id')
                        ->join('lmssections','schoolitems.sectionid','lmssections.id')
                        ->join('infraitems','schoolitems.itemid','infraitems.id')
                        ->where('schoolitems.mid',$this->id)
                        ->select('categories.categories','lmssections.section','infraitems.infraitem','schoolitems.itemno','schoolitems.itemdesc')
                        ->get();
    }

    public function headings(): array
    {
        return [
            'Class',
            'Section',
            'Items',
            'Item No',  
            'Item Desc'
        ];
    }
}
