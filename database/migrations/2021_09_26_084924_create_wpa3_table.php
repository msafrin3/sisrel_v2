<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpa3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wpa3', function (Blueprint $table) {
            $table->id();
            $table->integer('pelesen_id');
            $table->integer('office_id');
            $table->date('date')->nullable();
            $table->double('quantity')->nullable();
            $table->integer('kod_hasil')->nullable();
            $table->double('levi_rate')->nullable();
            $table->double('levi_price')->nullable();
            $table->double('penalty_rate')->nullable();
            $table->double('penalty_price')->nullable();
            $table->longText('signature_pelesen')->nullable();
            $table->integer('pic_id')->nullable();
            $table->integer('confirmed_by')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->longText('confirmed_signature')->nullable();
            $table->enum('status', ['pending', 'processing', 'confirmed', 'cancelled'])->nullable();
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
        Schema::dropIfExists('wpa3');
    }
}
