<?php

namespace App\Exports;

use App\Models\CierreCaja;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CierreCajasExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * Devuelve la colección de cierres con formato
     */
    public function collection()
    {
        return CierreCaja::with('caja')->get()->map(function ($cierre) {
            return [
                'caja_id'       => $cierre->caja->id ?? 'N/A',
                'fecha'         => $cierre->fecha->format('Y-m-d'),
                'observaciones' => $cierre->observaciones ?? '',
            ];
        });
    }

    /**
     * Cabeceras de columnas para el archivo Excel
     */
    public function headings(): array
    {
        return [
            'Caja ID',
            'Fecha',
            'Observaciones',
        ];
    }

    /**
     * Estilos aplicados al archivo Excel
     */
    public function styles(Worksheet $sheet)
    {
        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']],
            ],
            'A1:C' . $sheet->getHighestRow() => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']]
                ]
            ],
        ];
    }
}
