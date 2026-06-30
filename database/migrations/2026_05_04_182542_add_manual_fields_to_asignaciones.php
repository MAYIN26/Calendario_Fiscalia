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
    Schema::table('asignaciones_calendario', function (Blueprint $table) {
        $table->boolean('modificado_manual')->default(false);
        $table->unsignedBigInteger('empleado_original_id')->nullable();
    });
}

public function down(): void
{
    Schema::table('asignaciones_calendario', function (Blueprint $table) {
        $table->dropColumn(['modificado_manual', 'empleado_original_id']);
    });
}
};