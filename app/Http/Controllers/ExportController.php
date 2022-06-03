<?php

namespace App\Http\Controllers;

use App\Exports\CryptoDepositExport;
use App\Models\CryptoWithdraw;
use Illuminate\Http\Request;
use App\Exports\RequestLiquidityExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InternalTransferExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    public function internalTransferExport(): BinaryFileResponse
    {
        return Excel::download(
            new InternalTransferExport,
            "internal-transfer-history-" . date("Ymd_His") . ".xlsx"
        );
    }

    public function requestLiqudityExport(): BinaryFileResponse
    {
        return Excel::download(
            new RequestLiquidityExport,
            "request-liquidity-history-" . date("Ymd_His") . ".xlsx"
        );
    }

    public function cryptoDepositExport(): BinaryFileResponse
    {
        return Excel::download(
            new CryptoDepositExport,
            "crypto-deposit-history-" . date("Ymd_His") . ".xlsx"
        );
    }

    public function cryptoWithdrawExport(): BinaryFileResponse
    {
        return Excel::download(
            new CryptoWithDrawExport,
            "crypto-withdraw-history-" . date("Ymd_His") . ".xlsx"
        );
    }
}
