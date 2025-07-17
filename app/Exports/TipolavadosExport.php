<?php

namespace App\Exports;

use App\Models\Tipolavado;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TipolavadosExport implements FromCollection
{ public function collection()
    {
        return Tipolavado::all()->map(function ($tipolavado) {
            return [
                'nombre' => $tipolavado->nombre,
                'precio' => $tipolavado->precio,

            ];
        });
    }

    public function headings(): array
    {
        return [
            'nombre',
            'precio ',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']],
            ],
            'A1:F' . $sheet->getHighestRow() => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']]
                ]
            ],
        ];
    }
}
