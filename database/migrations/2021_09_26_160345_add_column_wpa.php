<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnWpa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wpa3', function(Blueprint $table) {
            $table->string('resit_no')->nullable()->after('status');
            $table->integer('payment_by')->nullable()->after('resit_no');
            $table->timestamp('payment_at')->nullable()->after('payment_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wpa3', function(Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('resit_no');
            $table->dropColumn('payment_at');
        });
    }
}
