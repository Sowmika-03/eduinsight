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
        Schema::table('academic_risk', function (Blueprint $table) {
            if (!Schema::hasColumn('academic_risk', 'risk_description')) {
                $table->string('risk_description')->nullable()->after('risk_level');
            }
            if (!Schema::hasColumn('academic_risk', 'is_notified')) {
                $table->boolean('is_notified')->default(false)->after('risk_description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academic_risk', function (Blueprint $table) {
            $table->dropColumnIfExists(['risk_description', 'is_notified']);
        });
    }
};
