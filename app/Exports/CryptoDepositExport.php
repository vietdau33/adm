<?php

namespace App\Exports;

use App\Models\CryptoDeposit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CryptoDepositExport implements FromCollection, WithHeadings, WithMapping
{

    private $count = 1;

    public function collection()
    {
        return CryptoDeposit::getHistory();
    }

    public function headings(): array
    {
        return [
            '#',
            'User Request',
            'Date',
            'From Address',
            'To Address',
            'Type',
            'Amount',
            'Transfer Amount',
            'TxHash',
            'Note',
        ];
    }

    public function map($row): array
    {
        return [
            $this->count++,
            $row->user_request->username ?? '',
            __d($row->created_at),
            $row->from,
            $row->to,
            $row->method,
            $row->amount,
            (int)$row->amount * (float)$row->rate,
            $row->txhash,
            $row->note,
        ];
    }
}
