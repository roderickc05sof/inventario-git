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
        Schema::create('assets', function (Blueprint $table) {
             $table->id();

        $table->foreignId('category_id')
              ->constrained();

        $table->foreignId('manufacturer_id')
              ->constrained();

        $table->foreignId('location_id')
              ->constrained();

        $table->foreignId('status_id')
              ->constrained('asset_statuses');

        $table->string('name');
        $table->string('model_number', 100);
        $table->string('serial_number', 100);
        $table->string('inventory_tag', 100);

        $table->date('purchase_date');

        $table->decimal('cost', 10, 2);

        $table->text('notes');

        $table->timestamps();

        $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
