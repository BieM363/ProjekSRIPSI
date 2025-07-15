<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('parameter_indikators', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->integer('target');
        $table->string('satuan');
        $table->decimal('bobot', 5, 2); // 5 digit total, 2 digit di belakang koma
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameter_indikators');
    }
};
