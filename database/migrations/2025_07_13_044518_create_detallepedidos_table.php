<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_pedido');
            $table->unsignedBigInteger('id_tipolavado');
            $table->unsignedBigInteger('id_tiporopa');

            $table->integer('cantidad');
            $table->decimal('subtotal', 10, 2);

            $table->timestamps();

            // Relaciones foráneas
            $table->foreign('id_pedido')
                  ->references('id')
                  ->on('pedidos')
                  ->onDelete('cascade');

            $table->foreign('id_tipolavado')
                  ->references('id')
                  ->on('tipolavados')
                  ->onDelete('restrict');

            $table->foreign('id_tiporopa')
                  ->references('id')
                  ->on('tiporopas')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_pedidos');
    }
};
