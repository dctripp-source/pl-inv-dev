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
        Schema::table('businesses', function (Blueprint $table) {
            $table->string('owner_first_name_cyrillic')->nullable()->after('owner_first_name');
            $table->string('owner_last_name_cyrillic')->nullable()->after('owner_last_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn([
                'owner_first_name_cyrillic',
                'owner_last_name_cyrillic'
            ]);
        });
    }
};