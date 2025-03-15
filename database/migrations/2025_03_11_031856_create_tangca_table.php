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
        Schema::create('tangca', function (Blueprint $table) {
            $table->tinyInteger('tc_id', true, true);
            $table->date('ngay');
            $table->integer('sogio');
            $table->tinyInteger('nv_id')->unsigned();
            $table->foreign('nv_id')->references('nv_id')->on('nhanvien')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tangca');
        Schema::table('tangca', function (Blueprint $table) {
            $table->dropForeign(['tangca_nv_id_foreign']);
            $table->dropIndex(['tangca_nv_id_foreign']);
        });
    }
};
