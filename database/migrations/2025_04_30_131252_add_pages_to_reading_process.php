<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reading_progress', function (Blueprint $table) {
            $table->integer('total_pages')->default(0);
            $table->integer('current_page')->default(1);
        });
    }

    public function down()
    {
        Schema::table('reading_progress', function (Blueprint $table) {
            $table->dropColumn(['total_pages', 'current_page']);
        });
    }
};