<?php

namespace App\Exports;

use App\Models\Ingreso;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IngresosExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * Devuelve la colección de ingresos con formato
     */
    public function collection()
    {
        return Ingreso::with('pedido')->get()->map(function ($ingreso) {
            return [
                'pedido_id'   => $ingreso->pedido->id ?? 'N/A',
                'fecha'       => $ingreso->fecha->format('Y-m-d'),
                'monto'       => number_format($ingreso->monto, 2),
                'descripcion' => $ingreso->descripcion ?? '',
            ];
        });
    }

    /**
     * Cabeceras de columnas para el archivo Excel
     */
    public function headings(): array
    {
        return [
            'Pedido ID',
            'Fecha',
            'Monto',
            'Descripción',
        ];
    }

    /**
     * Estilos aplicados al archivo Excel
     */
    public function styles(Worksheet $sheet)
    {
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']],
            ],
            'A1:D' . $sheet->getHighestRow() => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']]
                ]
            ],
        ];
    }
}
