<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asignaciones_calendario', function (Blueprint $table) {
            if (!Schema::hasColumn('asignaciones_calendario', 'empleado_original_id')) {
                $table->unsignedBigInteger('empleado_original_id')->nullable();
            }

            if (!Schema::hasColumn('asignaciones_calendario', 'modificado_manual')) {
                $table->boolean('modificado_manual')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('asignaciones_calendario', function (Blueprint $table) {
            if (Schema::hasColumn('asignaciones_calendario', 'empleado_original_id')) {
                $table->dropColumn('empleado_original_id');
            }

            if (Schema::hasColumn('asignaciones_calendario', 'modificado_manual')) {
                $table->dropColumn('modificado_manual');
            }
        });
    }
};