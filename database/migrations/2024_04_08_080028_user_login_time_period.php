<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function(Blueprint $table){
            $table->timestamp('login_time')->nullable()->after('password');
            $table->timestamp('logout_time')->nullable()->after('login_time');
            $table->time('active_duration')->nullable()->after('logout_time');
        });
    }


    public function down(): void
    {
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn('login_time');
            $table->dropColumn('logout_time');
            $table->dropColumn('active_duartion');
        });
    }
};
