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
        Schema::create('dichvu', function (Blueprint $table) {
            $table->tinyInteger('dv_id', true, true);
            $table->string('tendichvu', 30);
            $table->boolean('forDog');
            $table->boolean('forCat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dichvu');
    }
};
