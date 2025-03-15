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
        Schema::create('ngaynghi', function (Blueprint $table) {
            $table->tinyInteger('nn_id', true, true);
            $table->date('ngay_off');
            $table->tinyInteger('nv_id')->unsigned();
            $table->foreign('nv_id')->references('nv_id')->on('nhanvien')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ngaynghi');
        Schema::table('ngaynghi', function (Blueprint $table) {
            $table->dropForeign(['ngaynghi_nv_id_foreign']);
            $table->dropIndex(['ngaynghi_nv_id_foreign']);
        });
    }
};
