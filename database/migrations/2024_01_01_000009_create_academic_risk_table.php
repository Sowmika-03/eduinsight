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
        Schema::create('academic_risk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->decimal('attendance_percentage', 5, 2);
            $table->decimal('internal_marks', 5, 2)->nullable();
            $table->decimal('external_marks', 5, 2)->nullable();
            $table->enum('risk_level', ['Low Risk', 'Medium Risk', 'High Risk'])->default('Low Risk');
            $table->float('risk_score')->nullable();
            $table->text('recommendations')->nullable();
            $table->timestamp('prediction_date')->nullable();
            $table->timestamps();
            
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_risk');
    }
};
