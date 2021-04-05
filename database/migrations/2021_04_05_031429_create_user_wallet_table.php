<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wallet', function (Blueprint $table) {
            $table->unsignedBigInteger('wallet_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('wallet_id')->references('id')->on('wallets');
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->unique(['user_id', 'wallet_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_wallet');
    }
}
