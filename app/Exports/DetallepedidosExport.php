<?php

namespace App\Exports;

use App\Models\DetallePedido;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DetallePedidosExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * Devuelve la colección de detalles de pedidos con atributos específicos
     */
    public function collection()
    {
        return DetallePedido::with(['pedido', 'tipoLavado', 'tipoRopa'])->get()->map(function ($detalle) {
            return [
                'pedido_id' => $detalle->id_pedido,
                'tipo_lavado' => $detalle->tipoLavado->nombre ?? 'N/A',
                'tipo_ropa' => $detalle->tipoRopa->nombre ?? 'N/A',
                'cantidad' => $detalle->cantidad,
                'subtotal' => number_format($detalle->subtotal, 2),
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
            'Tipo de Lavado',
            'Tipo de Ropa',
            'Cantidad',
            'Subtotal',
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
