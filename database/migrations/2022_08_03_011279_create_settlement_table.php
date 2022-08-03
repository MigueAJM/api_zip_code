<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlement', function (Blueprint $table) {
            $table->id();
            $table->string('zipcode', 5);
            $table->string('name', 30);
            $table->unsignedBigInteger('settlement_type_id');
            $table->integer('code');
            $table->unsignedBigInteger('zone_id');
            $table->unsignedBigInteger('city_id')->nullable();;
            $table->unsignedBigInteger('state_id')->nullable();;
            $table->timestamps();
            $table->foreign('settlement_type_id')->references('id')->on('settlement_type');
            $table->foreign('zone_id')->references('id')->on('zone_type');
            $table->foreign('city_id')->references('id')->on('city');
            $table->foreign('state_id')->references('id')->on('state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settlement');
    }
}
