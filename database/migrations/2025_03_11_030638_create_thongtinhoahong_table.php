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
        Schema::create('thongtinhoahong', function (Blueprint $table) {
            $table->tinyInteger('tt_id', true, true);
            $table->string('tt_tenboss',20);
            $table->boolean('cho_meo');
            $table->double('tt_weight');
            $table->double('tt_total');
            $table->tinyInteger('dvc_id')->unsigned();
            $table->dateTime('ngaygio');
            $table->double('hoa_hong');
            $table->tinyInteger('nv_id')->unsigned();
            $table->foreign('dvc_id')->references('dvc_id')->on('dichvucon')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('nv_id')->references('nv_id')->on('nhanvien')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thongtinhoahong');
        Schema::table('thongtinhoahong', function (Blueprint $table) {
            $table->dropForeign(['thongtinhoahong_dvc_id_foreign', 'thongtinhoahong_nv_id_foreign']);
            $table->dropIndex(['thongtinhoahong_dvc_id_foreign', 'thongtinhoahong_nv_id_foreign']);
        });
    }
};
