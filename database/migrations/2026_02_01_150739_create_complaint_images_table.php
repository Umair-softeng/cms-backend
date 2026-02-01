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
        Schema::create('complaintImages', function (Blueprint $table) {
            $table->id('complaintImageID');
            $table->string('image');
            $table->foreignId('complaintID')->constrained('complaints', 'complaintID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaintImages');
    }
};
