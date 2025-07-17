<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingreso;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IngresosExport; // Asegúrate de crear este Export

class IngresoController extends Controller
{
    public function index()
    {
        $ingresos = Ingreso::all();
        $pedidos = Pedido::all();

        return view('admin.ingreso.index', compact('ingresos', 'pedidos'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pedido' => 'required|exists:pedidos,id',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
        ]);

        try {
            $validator->validate();

            Ingreso::create([
                'id_pedido' => $request->id_pedido,
                'fecha' => $request->fecha,
                'monto' => $request->monto,
                'descripcion' => $request->descripcion,
            ]);

            return redirect()->route('admin.ingreso.index')
                ->with('success', 'El ingreso fue registrado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_pedido' => 'required|exists:pedidos,id',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
        ]);

        try {
            $validator->validate();

            $ingreso = Ingreso::findOrFail($id);
            $ingreso->update([
                'id_pedido' => $request->id_pedido,
                'fecha' => $request->fecha,
                'monto' => $request->monto,
                'descripcion' => $request->descripcion,
            ]);

            return redirect()->route('admin.ingreso.index')
                ->with('success', 'El ingreso fue actualizado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->delete();

        return redirect()->route('admin.ingreso.index')
            ->with('success', 'El ingreso fue eliminado correctamente.');
    }

    public function exportPdf()
    {
        $ingresos = Ingreso::all();
        $pdf = Pdf::loadView('admin.ingreso.pdf', compact('ingresos'));
        return $pdf->download('reporte_ingresos.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new IngresosExport, 'reporte_ingresos.xlsx');
    }
}
