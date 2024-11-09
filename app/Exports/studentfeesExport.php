<?php

namespace App\Exports;

use App\Models\student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class studentfeesExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($id) {
        $this->sid=$id;     
    }

    public function collection(){
            return student::join('feepayments','feepayments.sid','students.id')
            ->where('students.id',$this->sid)
            ->where('feepayments.sid',$this->sid)
            ->select('students.sregistrationnumber','students.sname','students.semail','students.snumber','feepayments.feeaprpay','feepayments.feemaypay','feepayments.feejunpay','feepayments.feejulpay','feepayments.feeaugpay','feepayments.feeseppay','feepayments.feeoctpay','feepayments.feenovpay','feepayments.feedecpay','feepayments.feejanpay','feepayments.feefebpay','feepayments.feemarpay','feepayments.feetotalremaining','feepayments.feetotalpaid','feepayments.feetotal')
            ->get();
    }

    public function headings(): array{
        return [
            'Registration Number',
            'Name',
            'Email',
            'Number',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
            'January',
            'February',
            'March',
            'Unpaid Fees',
            'Paid Fees',
            'Total Fees'
        ];
    }
}
