<?php

namespace App\Exports;

use App\Models\InternalTransferHistory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InternalTransferExport implements FromCollection, WithHeadings, WithMapping
{

    private $stt = 1;
    /**
     * @return string[]
     */
    public function headings(): array
    {
        return [
            '#',
            'Date',
            'From',
            'To',
            'Amount',
            'Note',
        ];
    }

    /**
     * @param $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $this->stt++,
            __d($row->created_at),
            $row->user_from()->username ?? "",
            $row->user_to()->username ?? "",
            number_format((float)$row->amount, 2) . " £",
            "'" . $row->note,
        ];
    }

    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return InternalTransferHistory::getHistory();
    }
}
