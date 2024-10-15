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
        Schema::table('messages', function (Blueprint $table) {
            $table->string('receiver_id')->nullable()->after('sender_id');
            $table->foreignId('chat_room_id')->after('sender_id');
            $table->string('ip')->after('message')->nullable();
            $table->text('useragent')->after('ip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('receiver_id');
            $table->dropColumn('ip');
            $table->dropColumn('useragent');
        });
    }
};
