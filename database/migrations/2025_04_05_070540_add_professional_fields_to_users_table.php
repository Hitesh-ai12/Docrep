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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable();
            $table->string('hospital_name')->nullable();
            $table->text('hospital_location')->nullable();
            $table->string('designation')->nullable();
            $table->string('years_of_experience')->nullable();
            $table->date('dob')->nullable();
            $table->string('wedding_date')->nullable();
            $table->string('location')->nullable();
            $table->string('current_work_availability')->nullable();
            $table->string('preferred_consultation_method')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
