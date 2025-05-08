<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('seos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model');
            $table->bigInteger('model_id');
            $table->text('title')->nullable();
            $table->longText('description')->nullable();
            $table->longText('keyword')->nullable();
            $table->text('canonical')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_noindex')->default(false);
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
        Schema::dropIfExists('seos');
    }
}
