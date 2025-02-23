<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('usercertifications')) {
            Schema::dropIfExists('usercertifications');
        }

        Schema::create('usercertifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userid');
            $table->string('name');
            $table->string('file');
            $table->string('organization');
            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usercertifications');
    }
};