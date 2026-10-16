<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('education_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_member_id')->constrained()->cascadeOnDelete();
            $table->string('degree'); // e.g. "S1 Pendidikan Anak Usia Dini"
            $table->string('institution');
            $table->string('year', 20)->nullable(); // free text: "2015" or "2013–2017"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('education_histories');
    }
};
