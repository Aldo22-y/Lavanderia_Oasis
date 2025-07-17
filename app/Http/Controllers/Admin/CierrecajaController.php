<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CierreCaja;
use App\Models\Caja;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CierreCajasExport;

class CierreCajaController extends Controller
{
    public function index()
    {
        $cierres = CierreCaja::with('caja')->get(); // Asume relación con Caja
        return view('admin.cierrecaja.index', compact('cierres'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_caja' => 'required|exists:cajas,id',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string|max:255',
        ]);

        try {
            $validator->validate();

            CierreCaja::create([
                'id_caja' => $request->id_caja,
                'fecha' => $request->fecha,
                'observaciones' => $request->observaciones,
            ]);

            return redirect()->route('admin.cierrecaja.index')
                ->with('success', 'El cierre de caja fue registrado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_caja' => 'required|exists:cajas,id',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string|max:255',
        ]);

        try {
            $validator->validate();

            $cierre = CierreCaja::findOrFail($id);
            $cierre->update([
                'id_caja' => $request->id_caja,
                'fecha' => $request->fecha,
                'observaciones' => $request->observaciones,
            ]);

            return redirect()->route('admin.cierrecaja.index')
                ->with('success', 'El cierre de caja fue actualizado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $cierre = CierreCaja::findOrFail($id);
        $cierre->delete();

        return redirect()->route('admin.cierrecaja.index')
            ->with('success', 'El cierre de caja fue eliminado correctamente.');
    }

    public function exportPdf()
    {
        $cierres = CierreCaja::with('caja')->get();
        $pdf = Pdf::loadView('admin.cierrecaja.pdf', compact('cierres'));
        return $pdf->download('reporte_cierres_caja.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new CierreCajasExport, 'reporte_cierres_caja.xlsx');
    }
}
