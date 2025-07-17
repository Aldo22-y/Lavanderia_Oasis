<?php

namespace App\Exports;

use App\Models\Egreso;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EgresosExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * Devuelve los datos a exportar
     */
    public function collection()
    {
        return Egreso::all()->map(function ($egreso) {
            return [
                'fecha'        => $egreso->fecha->format('d/m/Y'),
                'monto'        => number_format($egreso->monto, 2),
                'descripcion'  => $egreso->descripcion ?? '---',
                'tipo_egreso'  => $egreso->tipo_egreso,
            ];
        });
    }

    /**
     * Encabezados del archivo Excel
     */
    public function headings(): array
    {
        return [
            'Fecha',
            'Monto (S/.)',
            'Descripción',
            'Tipo de Egreso',
        ];
    }

    /**
     * Estilos aplicados al archivo
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
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']],
                ],
            ],
        ];
    }
}
