<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('title')->nullable();
            $table->string('issue')->nullable();
            $table->string('email');
            $table->string('phone_number')->nullable();
            $table->integer('contact_receiver_id');
            $table->string('address')->nullable();
            $table->text('content')->nullable();
            $table->integer('status');
            $table->integer('is_important');
            $table->string('id_card_number')->nullable();
            $table->text('note')->nullable();
            $table->integer('city')->nullable();
            $table->integer('district')->nullable();
            $table->integer('user_created')->nullable();
            $table->integer('user_updated')->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
