<?php

namespace App\Exports;

use App\Models\Tiporopa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TiporopasExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * Devuelve la colección de tipos de ropa.
     */
    public function collection()
    {
        return Tiporopa::all()->map(function ($tiporopa) {
            return [
                'descripcion' => $tiporopa->descripcion,
            ];
        });
    }

    /**
     * Encabezados de las columnas.
     */
    public function headings(): array
    {
        return [
            'Descripción',
        ];
    }

    /**
     * Estilos para la hoja de cálculo.
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setAutoSize(true);

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']],
            ],
            'A1:A' . $sheet->getHighestRow() => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']],
                ],
            ],
        ];
    }
}
