<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssetsList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('binanceId')->nullable();
            $table->string('assetCode')->nullable();
            $table->string('assetName')->nullable();
            $table->string('commissionRate')->nullable();
            $table->dateTime('createTime')->nullable();
            $table->boolean('isLegalMoney')->nullable();
            $table->string('chineseName')->nullable();
            $table->string('logoUrl')->nullable();
            $table->string('fullLogoUrl')->nullable();
            $table->string('feeRate')->nullable();
            $table->string('assetDigit')->nullable();
            $table->boolean('trading')->nullable();
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
        Schema::dropIfExists('assets');
    }
}
