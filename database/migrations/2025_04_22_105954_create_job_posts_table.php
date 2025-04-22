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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('industry');
            $table->text('company_description')->nullable();
            $table->string('job_title');
            $table->string('city');
            $table->string('area')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('street_address')->nullable();
            $table->json('job_types')->nullable();
            $table->json('schedules')->nullable();
            $table->string('recruitment_timeline')->nullable();
            $table->string('people_required')->nullable();
            $table->text('job_description')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
