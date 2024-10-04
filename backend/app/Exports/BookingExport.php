<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingExport implements WithMapping, FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'Name',
            'Property Name',
            'Cost',
            'Check In',
            'Check Out',
            'Status',
        ];
    }
    public function map($booking): array
    {
        return [
            optional($booking->user)->name,
            optional($booking->property)->name,
            optional($booking->property)->price,
            $booking->check_in,
            $booking->check_out,
            $booking->status,
        ];
    }
    public function collection()
    {
        return Booking::with("user", "property")->get();
    }
}
