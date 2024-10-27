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
        Schema::table('users', function (Blueprint $table) {
            $table->string('ip')->after('remember_token')->nullable();
            $table->text('useragent')->after('ip')->nullable();
            $table->boolean('online')->default(false)->after('remember_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('ip');
            $table->dropColumn('useragent');
            $table->dropColumn('online');
        });
    }
};
