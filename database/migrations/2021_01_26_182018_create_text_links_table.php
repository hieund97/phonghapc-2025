<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('text_links', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->bigInteger('model_id')->default(0)->nullable();
            $table->string('text')->nullable();
            $table->string('link')->nullable();
            $table->string('rel')->nullable();
            $table->string('thumbnail')->nullable();
            $table->bigInteger('sort')->default(0);
            $table->tinyInteger('type')->nullable()->default(1); // 1 Thương hiệu, 2. Loại sản phẩm
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
        Schema::dropIfExists('text_links');
    }
}
