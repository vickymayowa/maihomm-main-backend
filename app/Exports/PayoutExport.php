<?php

namespace App\Exports;

use App\Models\Booking;
use App\Models\Payout;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PayoutExport implements WithMapping, FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'Name',
            'Reference',
            'Amount',
            'Status',
            'Date',
        ];
    }
    public function map($payout): array
    {
        return [
            optional($payout->property->owner)->names(),
            $payout->reference,
            $payout->amount,
            $payout->status,
            $payout->created_at,
        ];
    }
    public function collection()
    {
        return Payout::with("property")->get();
    }
}
