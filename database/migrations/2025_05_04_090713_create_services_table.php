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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('service_code', 20)->unique();
            $table->foreignId('alat_id')->constrained('alats', 'id');
            $table->string('no_seri', 50);
            $table->string('service_name', 100);
            $table->string('service_type', 50);
            $table->date('service_date');
            $table->text('keluhan');
            $table->string('service_description', 255)->nullable();
            $table->string('service_price', 20);
            $table->string('service_duration', 20);
            $table->string('service_status', 20);
            $table->foreignId('perusahaan_id')->constrained('perusahaans', 'id');
            $table->foreignId('teknisi_id')->constrained('teknisis', 'id');
            $table->foreignId('rumah_sakit_id')->constrained('rumah_sakits', 'id');
            $table->boolean('is_deleted')->default(false);
            $table->string('created_by', 50);
            $table->timestamps();
        });

        Schema::create('lampiran_services', function (Blueprint $table) {
            $table->id();
            $table->string('service_code', 20);
            $table->string('lampiran_name', 100);
            $table->string('lampiran_path', 255);
            $table->timestamps();
        });
        Schema::create('foto_services', function (Blueprint $table) {
            $table->id();
            $table->string('service_code', 20);
            $table->string('foto', 100);
            $table->string('path', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
