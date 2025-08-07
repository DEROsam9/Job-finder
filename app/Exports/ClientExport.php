<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Style;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class ClientExport implements ShouldAutoSize, WithHeadings, FromArray , WithStyles , WithTitle , WithDefaultStyles
{
    use \Maatwebsite\Excel\Concerns\Exportable;
    
    protected $records;
     
    protected $title;

    public function __construct
    (
        Collection $_records,
                   $title
    )

    {
        $this->records = $_records;
        $this->title = $title;
    }

 public function array(): array
    {
        $rows = [];
        $rows[] = ['', '', '', '', ''];
        $rows[] = ['', '', '', '', ''];
        $rows[] = ['', '', '', '', ''];
        foreach ($this->records as $date => $record) {
            $rows[] = [$date, '', '', '', '', '', '', ''];

            foreach ($record->items as $item) {
            

                $rows[] = [
                    $item['client_name'] ?? '',
                    $item['client_email'] ?? '',
                    $item['client_phone_number'] ?? '',
                    $item['client_passport_number'] ?? '',
                    $item['client_id_number'] ?? '',
                ];
            }

            $rows[] = ['', '', '', '', ''];

        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            [''],
            ['Client Name', 'Client Email', 'Phone Number', 'Passport Number', 'ID Number'],
        ];
    }

    public function defaultStyles(Style $defaultStyle): array
    {
        return [
            'font' => [
                'size' => 12,
                'name' => 'Aptos Narrow',
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            2 => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => '2e79c5'],
                ],
                'font' => [
                    'size' => 12,
                    'name' => 'Aptos Narrow',
                    'color' => ['argb' => 'FFFFFF']
                ],
            ],

        ];
    }

    public function title(): string
    {
        return $this->title;
    }
}
