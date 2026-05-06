<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Stores formatted query results separately for display purposes
     */
    public function up(): void
    {
        Schema::table('nl_queries', function (Blueprint $table) {
            // Add columns to store formatted results and metadata
            if (!Schema::hasColumn('nl_queries', 'query_results_formatted')) {
                $table->longText('query_results_formatted')->nullable()->after('query_result');
            }
            if (!Schema::hasColumn('nl_queries', 'result_columns')) {
                $table->json('result_columns')->nullable()->after('query_results_formatted');
            }
            if (!Schema::hasColumn('nl_queries', 'result_count')) {
                $table->integer('result_count')->default(0)->after('result_columns');
            }
            if (!Schema::hasColumn('nl_queries', 'show_sql_to_user')) {
                $table->boolean('show_sql_to_user')->default(false)->after('result_count');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nl_queries', function (Blueprint $table) {
            $table->dropColumnIfExists(['query_results_formatted', 'result_columns', 'result_count', 'show_sql_to_user']);
        });
    }
};
