<?php
use Tests\TestCase;
use App\Models\Pedido;

class PruebaUnitariaPedidosTest extends TestCase {
    public function test_registrar_pedido() {
        $pedido = Pedido::create([
            'id_cliente' => 1,
            'fecha_ingreso' => now(),
            'total' => 100.00
        ]);
        $this->assertDatabaseHas('pedidos', ['total' => 100.00]);
    }
}
