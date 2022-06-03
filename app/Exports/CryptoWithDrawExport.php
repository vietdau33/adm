<?php

namespace App\Exports;

use App\Models\CryptoWithdraw;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CryptoWithDrawExport implements FromCollection, WithHeadings, WithMapping
{

    private $count = 1;

    public function collection()
    {
        return CryptoWithdraw::getHistory();
    }

    public function headings(): array
    {
        return [
            '#',
            'User Request',
            'Date',
            'To Address',
            'Type',
            'Amount',
            'Transfer Amount',
            'Note',
        ];
    }

    public function map($row): array
    {
        return [
            $this->count++,
            $row->user_request->username ?? '',
            __d($row->created_at),
            $row->to,
            $row->method,
            $row->amount,
            (int)$row->amount * (float)$row->rate,
            $row->note,
        ];
    }
}
