<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->integer('office_id')->after('id')->nullabel();
            $table->integer('pelesen_id')->after('office_id')->nullable();
            $table->string('ic')->after('pelesen_id')->nullable();
            $table->string('image')->after('remember_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('office_id');
            $table->dropColumn('pelesen_id');
            $table->dropColumn('ic');
            $table->dropColumn('image');
        });
    }
}
