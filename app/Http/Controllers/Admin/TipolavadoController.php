<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TipolavadosExport;
use App\Http\Controllers\Controller;
use App\Models\Tipolavado;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;


class TipolavadoController extends Controller
{
    public function index()
    {
        $tipos_lavado = Tipolavado::all(); // o ->paginate(10) si usas paginación
        return view('admin.tipolavado.index', compact('tipos_lavado'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        try {
            $validator->validate();

            Tipolavado::create([
                'nombre' => $request->nombre,
                'precio' => $request->precio,
            ]);

            return redirect()->route('admin.tipolavado.index')
                ->with('success', 'El tipo de lavado fue registrado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        try {
            $validator->validate();

            $lavado = Tipolavado::findOrFail($id);
            $lavado->update([
                'nombre' => $request->nombre,
                'precio' => $request->precio,
            ]);

            return redirect()->route('admin.tipolavado.index')
                ->with('success', 'El tipo de lavado fue actualizado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $lavado = Tipolavado::findOrFail($id);
        $lavado->delete(); // eliminación definitiva

        return redirect()->route('admin.tipolavado.index')
            ->with('success', 'El tipo de lavado fue eliminado correctamente.');
    }

        public function exportPdf()
    {
        $tipos_lavado = Tipolavado::all();
        $pdf = Pdf::loadView('Admin.tipolavado.pdf', compact('tipos_lavado'));
        return $pdf->download('reporte_tipolavado.pdf');
    }
 public function exportExcel()
    {
        return Excel::download(new TipolavadosExport(), 'reporte_tipolavado.xlsx');
    }

}
