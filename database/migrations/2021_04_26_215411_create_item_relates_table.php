<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemRelatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_relates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model');
            $table->bigInteger('model_id');
            $table->string('title');
            $table->string('link');
            $table->string('image');
            $table->string('rel')->nullable();
            $table->string('target')->nullable();
            $table->integer('sort')->default(0);
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
        Schema::dropIfExists('item_relates');
    }
}
