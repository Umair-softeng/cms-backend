<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaintImages', function (Blueprint $table) {
                $table->id('complaintImageID');
                $table->string('image');
                $table->enum('type', ['Complaint','Evidence'])->default('complaint');
                $table->foreignId('complaintID')->constrained('complaints', 'complaintID')->cascadeOnDelete();
                $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaintImages');
    }
};
