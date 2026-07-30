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
        Schema::table('events', function (Blueprint $table) {
            $table->renameColumn('couple_name', 'name');
            $table->renameColumn('wedding_date', 'event_date');
            $table->dropColumn(['bride_name', 'groom_name']);
            $table->string('event_type')->nullable()->after('id');
            $table->string('banner_image')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->renameColumn('name', 'couple_name');
            $table->renameColumn('event_date', 'wedding_date');
            $table->string('bride_name')->nullable();
            $table->string('groom_name')->nullable();
            $table->dropColumn(['event_type', 'banner_image']);
        });
    }
};
