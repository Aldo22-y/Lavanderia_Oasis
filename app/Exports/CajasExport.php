<?php

namespace App\Exports;

use App\Models\Caja;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CajasExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Caja::all()->map(function ($caja) {
            return [
                'fecha_apertura'  => $caja->fecha_apertura,
                'fecha_cierre'    => $caja->fecha_cierre,
                'total_ingresos'  => $caja->total_ingresos,
                'total_egresos'   => $caja->total_egresos,
                'saldo_final'     => $caja->saldo_final,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Fecha de Apertura',
            'Fecha de Cierre',
            'Total Ingresos',
            'Total Egresos',
            'Saldo Final',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Ajustar ancho automático de las columnas A a E
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']],
            ],
            'A1:E' . $sheet->getHighestRow() => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']],
                ],
            ],
        ];
    }
}
