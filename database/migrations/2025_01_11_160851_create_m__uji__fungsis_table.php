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
        Schema::create('m_uji_fungsis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alat_id')->constrained('alats');
            $table->text('item');
            $table->integer('qty');
            $table->string('satuan', 50);
            $table->timestamps();
        });

        schema::create('data_uji_fungsis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alat_id');
            $table->foreign('alat_id')->references('id')->on('alats')->onDelete('cascade');
            $table->string('no_seri', 50)->nullable();
            $table->string('no_order', 50)->nullable();
            $table->string('no_faktur', 50)->nullable();
            $table->date('tgl_faktur')->nullable();
            $table->date('tgl_terima')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('created_by_user_id', 20);
            $table->string('teknisi', 50);
            $table->string('status', 50);
            $table->boolean('is_deleted');
            $table->timestamps();
        });

        Schema::create('detail_uji_fungsis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_uji_fungsi_id')->constrained('data_uji_fungsis')->onDelete('cascade');
            $table->string('item', 100);
            $table->integer('qty');
            $table->string('satuan', 50);
            $table->boolean('status');
            $table->string('foto');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_uji_fungsis');
        Schema::dropIfExists('data_uji_fungsis');
        Schema::dropIfExists('detail_uji_fungsis');
    }
};
