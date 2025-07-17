<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DetallePedidosExport;
use App\Http\Controllers\Controller;
use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\TipoLavado;
use App\Models\TipoRopa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class DetallePedidoController extends Controller
{
    public function index()
    {
        $detallepedidos = DetallePedido::all();
        $pedidos = Pedido::all();
        $tipolavados = TipoLavado::all();
        $tiporopas = TipoRopa::all();

        return view('admin.detallepedido.index', compact('detallepedidos', 'pedidos', 'tipolavados', 'tiporopas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pedido' => 'required|exists:pedidos,id',
            'id_tipolavado' => 'required|exists:tipolavados,id',
            'id_tiporopa' => 'required|exists:tiporopas,id',
            'cantidad' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0',
        ]);

        try {
            $validator->validate();

            DetallePedido::create([
                'id_pedido' => $request->id_pedido,
                'id_tipolavado' => $request->id_tipolavado,
                'id_tiporopa' => $request->id_tiporopa,
                'cantidad' => $request->cantidad,
                'subtotal' => $request->subtotal,
            ]);

            return redirect()->route('admin.detallepedido.index')
                ->with('success', 'El detalle de pedido fue registrado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_pedido' => 'required|exists:pedidos,id',
            'id_tipolavado' => 'required|exists:tipolavados,id',
            'id_tiporopa' => 'required|exists:tiporopas,id',
            'cantidad' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0',
        ]);

        try {
            $validator->validate();

            $detalle = DetallePedido::findOrFail($id);
            $detalle->update([
                'id_pedido' => $request->id_pedido,
                'id_tipolavado' => $request->id_tipolavado,
                'id_tiporopa' => $request->id_tiporopa,
                'cantidad' => $request->cantidad,
                'subtotal' => $request->subtotal,
            ]);

            return redirect()->route('admin.detallepedido.index')
                ->with('success', 'El detalle de pedido fue actualizado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $detalle = DetallePedido::findOrFail($id);
        $detalle->delete();

        return redirect()->route('admin.detallepedido.index')
            ->with('success', 'El detalle de pedido fue eliminado correctamente.');
    }

    public function exportPdf()
    {
        $detallepedidos = DetallePedido::all(); // o aplicar filtros si deseas
        $pdf = Pdf::loadView('admin.detallepedido.pdf', compact('detallepedidos'));
        return $pdf->download('reporte_detallepedidos.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new DetallePedidosExport, 'reporte_detallepedidos.xlsx');
    }
}
