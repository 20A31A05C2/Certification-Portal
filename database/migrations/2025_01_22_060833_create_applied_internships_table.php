<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applied_internships', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userid');  // Changed to bigInteger to match users table
            $table->string('name');
            $table->string('organization');
            $table->date('end_date')->nullable();
            $table->enum('status', ['applied', 'rejected']);
            $table->timestamps();
            
            // Remove foreign key completely since we're dealing with a non-standard ID system
            // $table->foreign('userid')->references('userid')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applied_internships');
    }
};