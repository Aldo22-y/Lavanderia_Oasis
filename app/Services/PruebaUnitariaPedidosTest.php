<?php
use Tests\TestCase;

class PruebaUnitariaSeguridadTest extends TestCase {
    public function test_login_correcto() {
        $response = $this->post('/login', [
            'email' => 'admin@correo.com',
            'password' => 'password'
        ]);
        $response->assertRedirect('/home');
    }
}
