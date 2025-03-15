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
        Schema::create('dichvucon', function (Blueprint $table) {
            $table->tinyInteger('dvc_id', true, true);
            $table->string('tendichvucon', 50);
            $table->boolean('forDog');
            $table->boolean('forCat');
            $table->double('tilehh');
            $table->tinyInteger('dv_id')->unsigned();
            $table->foreign('dv_id')->references('dv_id')->on('dichvu')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dichvucon');
        Schema::table('dichvucon', function (Blueprint $table) {
            $table->dropForeign(['dichvucon_dv_id_foreign']);
            $table->dropIndex(['dichvucon_dv_id_foreign']);
        });
    }
};
