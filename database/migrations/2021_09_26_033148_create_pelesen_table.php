<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelesenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelesen', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('accountant_name')->nullable();
            $table->text('address')->nullable();
            $table->string('license_no')->nullable();
            $table->string('file_no')->nullable();
            $table->double('area')->nullable()->default(0.00)->comment('land area by hectares');
            $table->string('contact_no')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pelesen');
    }
}
