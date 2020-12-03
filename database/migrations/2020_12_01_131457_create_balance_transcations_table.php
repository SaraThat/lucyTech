<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceTranscationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_transcations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id')->unsigned()->index();
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
            $table->float('amount',8,2)->nullable();
            $table->float('amount_before',8,2)->nullable();
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
        Schema::dropIfExists('balance_transcations');
    }
}
