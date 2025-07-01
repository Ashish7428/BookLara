<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected', 'deleted', 'deleted_by_author'])->default('pending')->change();
            $table->enum('previous_status', ['pending', 'approved', 'rejected', 'deleted', 'deleted_by_author'])->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('previous_status');
            $table->enum('status', ['pending', 'approved', 'rejected', 'deleted'])->default('pending')->change();
        });
    }
};
