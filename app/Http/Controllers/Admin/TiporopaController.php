<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TiporopasExport;
use App\Http\Controllers\Controller;
use App\Models\Tiporopa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class TiporopaController extends Controller
{
    public function index()
    {
        $tiporopas = Tiporopa::all(); // o ->paginate(10) si usas paginación
        return view('admin.tiporopa.index', compact('tiporopas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:255',
        ]);

        try {
            $validator->validate();

            Tiporopa::create([
                'descripcion' => $request->descripcion,
            ]);

            return redirect()->route('admin.tiporopa.index')
                ->with('success', 'El tipo de ropa fue registrado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:255',
        ]);

        try {
            $validator->validate();

            $tiporopa = Tiporopa::findOrFail($id);
            $tiporopa->update([
                'descripcion' => $request->descripcion,
            ]);

            return redirect()->route('admin.tiporopa.index')
                ->with('success', 'El tipo de ropa fue actualizado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $tiporopa = Tiporopa::findOrFail($id);
        $tiporopa->delete();

        return redirect()->route('admin.tiporopa.index')
            ->with('success', 'El tipo de ropa fue eliminado correctamente.');
    }

    public function exportPdf()
    {
        $tiporopas = Tiporopa::all();
        $pdf = Pdf::loadView('admin.tiporopa.pdf', compact('tiporopas'));
        return $pdf->download('reporte_tiporopa.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new TiporopasExport(), 'reporte_tiporopa.xlsx');
    }
}
