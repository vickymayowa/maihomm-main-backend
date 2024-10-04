<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SamplePropertyExport implements WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
    public function headings(): array
    {
       return [
        'Name*',
        'Price*',
        'Currency*',
        'Sqft',
        'bedrooms',
        'Bathrooms',
        'Address',
        'Landmark',
        'Country',
        'State',
        'City',
        'Closing Date',
        'First Year Projection',
        'Fifth Year Projection',
        'Tenth Year Projection',
        'Legal And Closing Cost',
        'Per Slot',
        'Total Sold',
        'Total Slots',
        'Property Acq Cost',
        'Service Charge',
        'Maihomm Fee',
        'Management Fees',
        'Projected Gross Rent',
        'One Time Payment Per Slot',
        'Rental Cost Per Night',
        'Projected Annual Yield',
        'projected_annual_yield_subtext',
        'average_occupancy',
        'Projected Annual Net Rental Income',
        'Projected Annual Rental Income Per Slot',
        'Description',
       ];
    }
}
