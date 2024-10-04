<?php

namespace App\Exports;

use App\Models\Payment;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaymentExport implements WithMapping, FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'Currency',
            'Reference',
            'Discount',
            'Amount',
            'Fee',
            'User',
            'Coupon Code',
            'Gateway',
            'Activity',
            'Confirmed At',
            'Status',
            'Created At',
        ];
    }
    public function map($payment): array
    {
        return [
            $payment->currency->name,
            $payment->reference,
            $payment->discount,
            $payment->amount,
            $payment->fee,
            $payment->user->full_name,
            $payment->coupon_code,
            $payment->gateway,
            $payment->activity,
            Carbon::parse($payment->confirmed_at)->toFormattedDateString(),
            $payment->status,
            Carbon::parse($payment->created_at)->toFormattedDateString()
        ];
    }
    public function collection()
    {
        return Payment::with("user", "currency")->get();
    }
}
