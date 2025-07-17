<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CajasExport;
use App\Http\Controllers\Controller;
use App\Models\Caja;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class CajaController extends Controller
{
    public function index()
    {
        $cajas = Caja::all(); // o ->paginate(10)
        return view('admin.caja.index', compact('cajas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha_apertura' => 'required|date',
            'fecha_cierre' => 'nullable|date|after_or_equal:fecha_apertura',
            'total_ingresos' => 'required|numeric|min:0',
            'total_egresos' => 'required|numeric|min:0',
            'saldo_final' => 'required|numeric',
        ]);

        try {
            $validator->validate();

            Caja::create([
                'fecha_apertura' => $request->fecha_apertura,
                'fecha_cierre' => $request->fecha_cierre,
                'total_ingresos' => $request->total_ingresos,
                'total_egresos' => $request->total_egresos,
                'saldo_final' => $request->saldo_final,
            ]);

            return redirect()->route('admin.caja.index')
                ->with('success', 'Caja registrada correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'fecha_apertura' => 'required|date',
            'fecha_cierre' => 'nullable|date|after_or_equal:fecha_apertura',
            'total_ingresos' => 'required|numeric|min:0',
            'total_egresos' => 'required|numeric|min:0',
            'saldo_final' => 'required|numeric',
        ]);

        try {
            $validator->validate();

            $caja = Caja::findOrFail($id);
            $caja->update([
                'fecha_apertura' => $request->fecha_apertura,
                'fecha_cierre' => $request->fecha_cierre,
                'total_ingresos' => $request->total_ingresos,
                'total_egresos' => $request->total_egresos,
                'saldo_final' => $request->saldo_final,
            ]);

            return redirect()->route('admin.caja.index')
                ->with('success', 'Caja actualizada correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $caja = Caja::findOrFail($id);
        $caja->delete();

        return redirect()->route('admin.caja.index')
            ->with('success', 'Caja eliminada correctamente.');
    }

    public function exportPdf()
    {
        $cajas = Caja::all();
        $pdf = Pdf::loadView('admin.caja.pdf', compact('cajas'));
        return $pdf->download('reporte_cajas.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new CajasExport(), 'reporte_cajas.xlsx');
    }
}
