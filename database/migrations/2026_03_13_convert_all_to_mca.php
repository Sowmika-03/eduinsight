<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update all students program to MCA
        DB::table('students')->update([
            'program' => 'MCA'
        ]);
    }

    public function down(): void
    {
        // Rollback - revert to previous programs (not fully reversible without history)
        // This is just for demonstration - data loss is possible
    }
};
