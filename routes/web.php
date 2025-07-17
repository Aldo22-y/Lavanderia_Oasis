<?php

use App\Http\Controllers\Admin\CajaController;
use App\Http\Controllers\Admin\CierreCajaController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\DetallepedidoController;
use App\Http\Controllers\Admin\EgresoController;
use App\Http\Controllers\Admin\IngresoController;
use App\Http\Controllers\Admin\PedidoController;
use App\Http\Controllers\Admin\TipolavadoController;
use App\Http\Controllers\Admin\TiporopaController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {

    // Cliente
    Route::resource('cliente', ClienteController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('cliente')
        ->middleware('can:admin.cliente.index');
    Route::get('cliente/consultar-dni', [ClienteController::class, 'consultarDni'])
        ->name('cliente.consultar-dni')
        ->middleware('can:admin.cliente.consultar-dni');
    Route::get('cliente/export-pdf', [ClienteController::class, 'exportPdf'])
        ->name('cliente.export-pdf');
    Route::get('cliente/export-excel', [ClienteController::class, 'exportExcel'])
        ->name('cliente.export-excel');

    // Tipolavado
    Route::get('tipolavado', [TipolavadoController::class, 'index'])
        ->name('tipolavado.index')
        ->middleware('can:admin.tipolavado.index');
    Route::post('tipolavado', [TipolavadoController::class, 'store'])
        ->name('tipolavado.store')
        ->middleware('can:admin.tipolavado.store');
    Route::put('tipolavado/{id}', [TipolavadoController::class, 'update'])
        ->name('tipolavado.update')
        ->middleware('can:admin.tipolavado.update');
    Route::delete('tipolavado/{id}', [TipolavadoController::class, 'destroy'])
        ->name('tipolavado.destroy')
        ->middleware('can:admin.tipolavado.destroy');
    Route::get('tipolavado/export-pdf', [TipolavadoController::class, 'exportPdf'])
        ->name('tipolavado.export-pdf');
    Route::get('tipolavado/export-excel', [TipolavadoController::class, 'exportExcel'])
        ->name('tipolavado.export-excel');

    // Tiporopa
    Route::get('tiporopa', [TiporopaController::class, 'index'])
        ->name('tiporopa.index')
        ->middleware('can:admin.tiporopa.index');
    Route::post('tiporopa', [TiporopaController::class, 'store'])
        ->name('tiporopa.store')
        ->middleware('can:admin.tiporopa.store');
    Route::put('tiporopa/{id}', [TiporopaController::class, 'update'])
        ->name('tiporopa.update')
        ->middleware('can:admin.tiporopa.update');
    Route::delete('tiporopa/{id}', [TiporopaController::class, 'destroy'])
        ->name('tiporopa.destroy')
        ->middleware('can:admin.tiporopa.destroy');
    Route::get('tiporopa/export-pdf', [TiporopaController::class, 'exportPdf'])
        ->name('tiporopa.export-pdf');
    Route::get('tiporopa/export-excel', [TiporopaController::class, 'exportExcel'])
        ->name('tiporopa.export-excel');

    // Caja
    Route::get('caja', [CajaController::class, 'index'])
        ->name('caja.index')
        ->middleware('can:admin.caja.index');
    Route::post('caja', [CajaController::class, 'store'])
        ->name('caja.store')
        ->middleware('can:admin.caja.store');
    Route::put('caja/{id}', [CajaController::class, 'update'])
        ->name('caja.update')
        ->middleware('can:admin.caja.update');
    Route::delete('caja/{id}', [CajaController::class, 'destroy'])
        ->name('caja.destroy')
        ->middleware('can:admin.caja.destroy');
    Route::get('caja/export-pdf', [CajaController::class, 'exportPdf'])
        ->name('caja.export-pdf');
    Route::get('caja/export-excel', [CajaController::class, 'exportExcel'])
        ->name('caja.export-excel');

    // Pedido
    Route::get('pedido', [PedidoController::class, 'index'])
        ->name('pedido.index')
        ->middleware('can:admin.pedido.index');
    Route::post('pedido', [PedidoController::class, 'store'])
        ->name('pedido.store')
        ->middleware('can:admin.pedido.store');
    Route::put('pedido/{id}', [PedidoController::class, 'update'])
        ->name('pedido.update')
        ->middleware('can:admin.pedido.update');
    Route::delete('pedido/{id}', [PedidoController::class, 'destroy'])
        ->name('pedido.destroy')
        ->middleware('can:admin.pedido.destroy');
    Route::get('pedido/export-pdf', [PedidoController::class, 'exportPdf'])
        ->name('pedido.export-pdf');
    Route::get('pedido/export-excel', [PedidoController::class, 'exportExcel'])
        ->name('pedido.export-excel');

    // Detalle Pedido
    Route::get('detallepedido', [DetallepedidoController::class, 'index'])
        ->name('detallepedido.index')
        ->middleware('can:admin.detallepedido.index');
    Route::post('detallepedido', [DetallepedidoController::class, 'store'])
        ->name('detallepedido.store')
        ->middleware('can:admin.detallepedido.store');
    Route::put('detallepedido/{id}', [DetallepedidoController::class, 'update'])
        ->name('detallepedido.update')
        ->middleware('can:admin.detallepedido.update');
    Route::delete('detallepedido/{id}', [DetallepedidoController::class, 'destroy'])
        ->name('detallepedido.destroy')
        ->middleware('can:admin.detallepedido.destroy');
    Route::get('detallepedido/export-pdf', [DetallepedidoController::class, 'exportPdf'])
        ->name('detallepedido.export-pdf');
    Route::get('detallepedido/export-excel', [DetallepedidoController::class, 'exportExcel'])
        ->name('detallepedido.export-excel');

    // Ingreso
    Route::get('ingreso', [IngresoController::class, 'index'])
        ->name('ingreso.index')
        ->middleware('can:admin.ingreso.index');
    Route::post('ingreso', [IngresoController::class, 'store'])
        ->name('ingreso.store')
        ->middleware('can:admin.ingreso.store');
    Route::put('ingreso/{id}', [IngresoController::class, 'update'])
        ->name('ingreso.update')
        ->middleware('can:admin.ingreso.update');
    Route::delete('ingreso/{id}', [IngresoController::class, 'destroy'])
        ->name('ingreso.destroy')
        ->middleware('can:admin.ingreso.destroy');
    Route::get('ingreso/export-pdf', [IngresoController::class, 'exportPdf'])
        ->name('ingreso.export-pdf');
    Route::get('ingreso/export-excel', [IngresoController::class, 'exportExcel'])
        ->name('ingreso.export-excel');

    // Egreso
    Route::get('egreso', [EgresoController::class, 'index'])
        ->name('egreso.index')
        ->middleware('can:admin.egreso.index');
    Route::post('egreso', [EgresoController::class, 'store'])
        ->name('egreso.store')
        ->middleware('can:admin.egreso.store');
    Route::put('egreso/{id}', [EgresoController::class, 'update'])
        ->name('egreso.update')
        ->middleware('can:admin.egreso.update');
    Route::delete('egreso/{id}', [EgresoController::class, 'destroy'])
        ->name('egreso.destroy')
        ->middleware('can:admin.egreso.destroy');
    Route::get('egreso/export-pdf', [EgresoController::class, 'exportPdf'])
        ->name('egreso.export-pdf');
    Route::get('egreso/export-excel', [EgresoController::class, 'exportExcel'])
        ->name('egreso.export-excel');

    // Cierre Caja
    Route::get('cierrecaja', [CierreCajaController::class, 'index'])
        ->name('cierrecaja.index')
        ->middleware('can:admin.cierrecaja.index');
    Route::post('cierrecaja', [CierreCajaController::class, 'store'])
        ->name('cierrecaja.store')
        ->middleware('can:admin.cierrecaja.store');
    Route::put('cierrecaja/{id}', [CierreCajaController::class, 'update'])
        ->name('cierrecaja.update')
        ->middleware('can:admin.cierrecaja.update');
    Route::delete('cierrecaja/{id}', [CierreCajaController::class, 'destroy'])
        ->name('cierrecaja.destroy')
        ->middleware('can:admin.cierrecaja.destroy');
    Route::get('cierrecaja/export-pdf', [CierreCajaController::class, 'exportPdf'])
        ->name('cierrecaja.export-pdf');
    Route::get('cierrecaja/export-excel', [CierreCajaController::class, 'exportExcel'])
        ->name('cierrecaja.export-excel');
});

require __DIR__.'/auth.php';
