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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id('complaintID');
            $table->string('trackingID')->nullable();
            $table->string('name');
            $table->string('cnic');
            $table->string('mobileNo');
            $table->string('title')->nullable();
            $table->enum('status',['New','In-Progress','Resolved', 'Dropped'])->default('New');
            $table->enum('priority',['Normal','Escalated','Super Escalated'])->default('Normal');
            $table->longText('complaint')->nullable();
            $table->longText('location')->nullable();
            $table->longText('remarks')->nullable();
            $table->foreignId('userID')->nullable()->constrained('users', 'id')->nullOnDelete();
            $table->foreignId('branchID')->nullable()->constrained('branches', 'branchID')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
