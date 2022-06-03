<?php

namespace App\Exports;

use App\Models\TransferToAdmin;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RequestLiquidityExport implements FromCollection, WithHeadings, WithMapping
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
            'User Request',
            'Amount',
            'Note',
            'Status',
        ];
    }

    /**
     * @param $row
     * @return array
     */
    public function map($row): array
    {
        $status = "";
        switch ($row->status){
            case 0:
                $status = "Pending";
                break;
            case 1:
                $status = "Agree";
                break;
            case 2:
                $status = "Cancel";
                break;
        }
        return [
            $this->stt++,
            __d($row->created_at, 'd/m/Y'),
            $row->from,
            number_format((float)$row->amount, 2) . " £",
            "'" . $row->note,
            $status,
        ];
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return TransferToAdmin::getListTransferHistory();
    }
}
