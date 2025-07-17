<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PedidosExport;
use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Cliente;

class PedidoController extends Controller
{

public function index()
{
    $pedidos = Pedido::with('cliente')->get(); // Asegúrate de que estás obteniendo los pedidos correctamente
    return view('admin.pedido.index', compact('pedidos'));
}


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_cliente' => 'required|exists:clientes,id',
            'fecha_ingreso' => 'required|date',
            'fecha_entrega' => 'nullable|date|after_or_equal:fecha_ingreso',
            'total' => 'required|numeric|min:0',
        ]);

        try {
            $validator->validate();

            Pedido::create([
                'id_cliente' => $request->id_cliente,
                'fecha_ingreso' => $request->fecha_ingreso,
                'fecha_entrega' => $request->fecha_entrega,
                'total' => $request->total,
                'status' => true,
            ]);

            return redirect()->route('admin.pedido.index')
                ->with('success', 'El pedido fue registrado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_cliente' => 'required|exists:clientes,id',
            'fecha_ingreso' => 'required|date',
            'fecha_entrega' => 'nullable|date|after_or_equal:fecha_ingreso',
            'total' => 'required|numeric|min:0',
        ]);

        try {
            $validator->validate();

            $pedido = Pedido::findOrFail($id);
            $pedido->update([
                'id_cliente' => $request->id_cliente,
                'fecha_ingreso' => $request->fecha_ingreso,
                'fecha_entrega' => $request->fecha_entrega,
                'total' => $request->total,
            ]);

            return redirect()->route('admin.pedido.index')
                ->with('success', 'El pedido fue actualizado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->update(['status' => false]);

        return redirect()->route('admin.pedido.index')
            ->with('success', 'El pedido fue eliminado correctamente.');
    }

    public function exportPdf()
    {
        $pedidos = Pedido::where('status', true)->get();
        $pdf = Pdf::loadView('admin.pedido.pdf', compact('pedidos'));
        return $pdf->download('reporte_pedidos.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new PedidosExport, 'reporte_pedidos.xlsx');
    }
}
