<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('banner_settings', function (Blueprint $table) {
            $table->boolean('is_sub_banner')->default(false)->after('status');
            $table->boolean('is_single_banner')->default(false)->after('is_sub_banner');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banner_settings', function (Blueprint $table) {
            $table->dropColumn('is_sub_banner');
            $table->dropColumn('is_single_banner');
        });
    }
};
