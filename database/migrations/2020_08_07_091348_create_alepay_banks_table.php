<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlepayBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('alepay_banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bank_id')->index();
            $table->integer('installment_id');
            $table->integer('gateway_mid');
            $table->string('code');
            $table->string('name');
            $table->string('hotline')->nullable();
            $table->string('logo');
            $table->text('payment_methods');
            $table->boolean('not_validate_card_expire');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('alepay_banks');
    }
}
