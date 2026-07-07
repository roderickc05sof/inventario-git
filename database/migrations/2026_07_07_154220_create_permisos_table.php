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
        Schema::create('permisos', function (Blueprint $table) {
             $table->foreignId('id_role')
          ->constrained('roles', 'id_role')
          ->cascadeOnDelete();

             $table->foreignId('id_vista')
          ->constrained('vistas', 'id_vista')
          ->cascadeOnDelete();

             $table->primary(['id_role', 'id_vista']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permisos');
    }
};
