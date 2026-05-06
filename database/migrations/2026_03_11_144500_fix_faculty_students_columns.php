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
        Schema::table('faculty_students', function (Blueprint $table) {
            // Drop the incorrect timestamp column
            $table->dropColumn('assigned_by_admin_id');
        });

        Schema::table('faculty_students', function (Blueprint $table) {
            // Add as integer (user ID) instead
            $table->unsignedBigInteger('assigned_by_admin_id')->nullable()->after('student_id');
            $table->foreign('assigned_by_admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faculty_students', function (Blueprint $table) {
            $table->dropForeign(['assigned_by_admin_id']);
            $table->dropColumn('assigned_by_admin_id');
        });
    }
};
