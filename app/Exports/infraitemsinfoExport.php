<?php

namespace App\Exports;

use App\Models\infraitems;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class infraitemsinfoExport implements FromCollection,WithHeadings
{
    protected $id;

    function __construct($id) {
        $this->id = $id;
    }

    public function collection(){
        return infraitems::select('id','infraitem')->get();
    }

    public function headings(): array
    {
        return [
            'Item No',
            'Item Name'
        ];
    }
}
