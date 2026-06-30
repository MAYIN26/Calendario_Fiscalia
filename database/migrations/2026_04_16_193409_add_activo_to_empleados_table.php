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
    Schema::table('empleados', function (Blueprint $table) {
        if (!Schema::hasColumn('empleados', 'activo')) {
            $table->boolean('activo')->default(true);
        }
    });
}

public function down(): void
{
    Schema::table('empleados', function (Blueprint $table) {
        if (Schema::hasColumn('empleados', 'activo')) {
            $table->dropColumn('activo');
        }
    });
}
};