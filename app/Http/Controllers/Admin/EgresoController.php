<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Egreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EgresosExport;

class EgresoController extends Controller
{
    public function index()
    {
        $egresos = Egreso::all(); // o ->paginate(10) si usas paginación
        return view('admin.egreso.index', compact('egresos'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'tipo_egreso' => 'required|string|max:255',
        ]);

        try {
            $validator->validate();

            Egreso::create([
                'fecha' => $request->fecha,
                'monto' => $request->monto,
                'descripcion' => $request->descripcion,
                'tipo_egreso' => $request->tipo_egreso,
            ]);

            return redirect()->route('admin.egreso.index')
                ->with('success', 'El egreso fue registrado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'tipo_egreso' => 'required|string|max:255',
        ]);

        try {
            $validator->validate();

            $egreso = Egreso::findOrFail($id);
            $egreso->update([
                'fecha' => $request->fecha,
                'monto' => $request->monto,
                'descripcion' => $request->descripcion,
                'tipo_egreso' => $request->tipo_egreso,
            ]);

            return redirect()->route('admin.egreso.index')
                ->with('success', 'El egreso fue actualizado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $egreso = Egreso::findOrFail($id);
        $egreso->delete();

        return redirect()->route('admin.egreso.index')
            ->with('success', 'El egreso fue eliminado correctamente.');
    }

    public function exportPdf()
    {
        $egresos = Egreso::all();
        $pdf = Pdf::loadView('admin.egreso.pdf', compact('egresos'));
        return $pdf->download('reporte_egresos.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new EgresosExport(), 'reporte_egresos.xlsx');
    }
}
