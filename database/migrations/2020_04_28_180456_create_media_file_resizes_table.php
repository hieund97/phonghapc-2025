<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaFileResizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_file_resizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('media_file_id');
            $table->string('title')->nullable();
            $table->string('height')->nullable();
            $table->string('width')->nullable();
            $table->string('url')->nullable();
            $table->string('size_name')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('media_file_resizes');
    }
}
