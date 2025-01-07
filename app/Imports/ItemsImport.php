<?php
namespace App\Imports;

use App\Models\ExpenseItem;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemsImport implements ToModel, WithHeadingRow
{
    private $groupid;
    private $categoryid;
    private $subcategoryid;
    private $aid;
    private $nontechmanagerid;

    public function __construct($groupid, $categoryid, $subcategoryid, $aid, $nontechmanagerid)
    {
        $this->groupid = $groupid;
        $this->categoryid = $categoryid;
        $this->subcategoryid = $subcategoryid;
        $this->aid = $aid;
        $this->nontechmanagerid = $nontechmanagerid;
    }

    public function model(array $row)
    {
        return new ExpenseItem([
            'groupid' => $this->groupid,
            'categoryid' => $this->categoryid,
            'subcatid' => $this->subcategoryid,
            'item' => $row['item'],  // 'item' should match the header from the Excel file
            'quantity' => $row['quantity_measure'], // Assuming column 1 is quantity
            'aid' => $this->aid,
            'nontechmanagerid' => $this->nontechmanagerid,
        ]);
    }
}
