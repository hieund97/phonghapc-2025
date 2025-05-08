<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('product_id');
            $table->string('title')->nullable();
            $table->text('body');
            $table->tinyInteger('rating'); // 1-5
            $table->boolean('approved')->default(false);
            $table->integer('count_like')->default(0)->nullable();
            $table->integer('count_dislike')->default(0)->nullable();
            $table->dateTime('publish_at')->nullable();
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
        Schema::dropIfExists('reviews');
    }
}
