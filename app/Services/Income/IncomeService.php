<?php

namespace App\Services\Income;

use App\Constants\TransactionConstants;
use App\Models\UserTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IncomeService
{
    public static function history()
    {
        $totals = [];
        $today = Carbon::today();
        $sevenMonthsAgo = $today->subMonths(7);
        $months = [];
        for ($i = 0; $i < 7; $i++) {
            // $months[] = $today->addMonth()->format('F Y');
            $currentMonth = $today->format('F Y');

            $total = UserTransaction::selectRaw('SUM(CASE WHEN type = "debit" THEN amount ELSE 0 END) as debit_total')
                ->selectRaw('SUM(CASE WHEN type = "credit" THEN amount ELSE 0 END) as credit_total')
                ->selectRaw('GROUP_CONCAT(status SEPARATOR ", ") as statuses')
                ->whereYear('created_at', $today->year)
                ->whereMonth('created_at', $today->month)
                ->first();

            $totals[$currentMonth] = [
                'debit' => $total->debit_total ?? 0,
                'credit' => $total->credit_total ?? 0,
                'status' => $total->statuses
            ];
            $today->addMonth();
            $today->startOfMonth();
        }
        // dd($months);
        return $totals;
    }
}
