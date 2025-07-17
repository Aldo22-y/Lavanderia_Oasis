<?php
use Tests\TestCase;
use App\Models\Ingreso;

class PruebaUnitariaCajaTest extends TestCase {
    public function test_registrar_ingreso() {
        $ingreso = Ingreso::create([
            'id_pedido' => 1,
            'fecha' => now(),
            'monto' => 200.00
        ]);
        $this->assertDatabaseHas('ingresos', ['monto' => 200.00]);
    }
}
