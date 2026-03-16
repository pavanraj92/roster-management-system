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
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreignId('roster_id')->nullable()->constrained()->cascadeOnDelete()->after('clock_out');
            $table->enum('shift_status', ['pending', 'running', 'completed'])->default('pending')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['roster_id']);
            $table->dropColumn('roster_id');
            $table->dropColumn('shift_status');
        });
    }
};
