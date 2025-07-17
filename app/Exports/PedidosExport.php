<?php

namespace App\Exports;

use App\Models\Pedido;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PedidosExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * Devuelve la colección de pedidos con atributos específicos
     */
    public function collection()
    {
        return Pedido::all()->map(function ($pedido) {
            return [
                'cliente_id' => $pedido->id_cliente,
                'fecha_ingreso' => $pedido->fecha_ingreso,
                'fecha_entrega' => $pedido->fecha_entrega,
                'total' => $pedido->total,
                'estado' => $pedido->status ? 'Activo' : 'Inactivo',
            ];
        });
    }

    /**
     * Cabeceras de columnas para el archivo Excel
     */
    public function headings(): array
    {
        return [
            'Cliente ID',
            'Fecha de Ingreso',
            'Fecha de Entrega',
            'Total',
            'Estado',
        ];
    }

    /**
     * Estilos aplicados al archivo Excel
     */
    public function styles(Worksheet $sheet)
    {
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
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']]
                ]
            ],
        ];
    }
}
