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
        Schema::create('detail_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained('stocks')->onDelete('cascade');
            $table->foreignId('alat_id')->constrained('alats')->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('cascade');
            $table->string('no_seri', 100);
            $table->date('date_in')->nullable();
            $table->date('date_out')->nullable();
            $table->string('status', 50);
            $table->string('condition', 50)->nullable();
            $table->foreignId('perusahaan_id')->constrained('perusahaans')->onDelete('cascade');
            $table->string('instalation_code', 100)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_out')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_stocks');
    }
};
