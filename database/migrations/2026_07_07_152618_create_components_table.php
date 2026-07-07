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
        Schema::create('components', function (Blueprint $table) {
            $table->id();

        $table->foreignId('asset_id')
              ->constrained('assets')
              ->onDelete('cascade');

        $table->foreignId('component_type_id')
              ->constrained('component_types');

        $table->string('brand', 255)->nullable();
        $table->string('serial_number', 255)->nullable();
        $table->json('specifications')->nullable(); 

        $table->timestamps();
        $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('components');
    }
};
