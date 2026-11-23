<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('contact_number', 20);
            $table->string('purpose', 255);
            $table->string('person_to_visit', 100)->nullable();
            $table->string('department', 100)->nullable();
            $table->timestamp('time_in');
            $table->timestamp('time_out')->nullable();
            $table->foreignId('registered_by')->constrained('users');
            $table->foreignId('checked_out_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes(); // archiving = soft delete
            $table->index('time_in');
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
