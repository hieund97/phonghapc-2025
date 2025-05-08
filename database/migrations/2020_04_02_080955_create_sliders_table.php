<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Slider;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->text('info')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('link')->nullable();
            $table->integer('type')->default(Slider::TYPE_DESKTOP);
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('product_category_id')->default(0);
            $table->integer('sort')->default(0);
            $table->boolean('status')->default(true);            
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
        Schema::dropIfExists('sliders');
    }
}
