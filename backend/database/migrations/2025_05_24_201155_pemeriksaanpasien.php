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
        //
        Schema::create('pemeriksaanpasien', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->default(DB::raw('gen_random_uuid()'));
            $table->boolean('is_active')->default(true);
            $table->integer('bb');
            $table->integer('td');
            $table->string('keluhan')->nullable();
            $table->string('diagnosa')->nullable();
            $table->uuid('uuid_pasien');
            $table->timestamps();
        });

        Schema::table('pemeriksaanpasien', function (Blueprint $table) {
            $table->foreign('uuid_pasien')->references('uuid')->on('pasien')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
