<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrawlReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_reports', function (Blueprint $table) {
            $table->id();
            $table->text('url');
            $table->text('info_product_url')->nullable();
            $table->integer('type')->default(1)->comment('1. hacom, 2. AnPhat, 3. Nguyencong, 4. HoangHa');
            $table->integer('product_id');
            $table->integer('status')->default(2)->comment('1. Match price, 2. Not match price');
            $table->dateTime('last_update')->useCurrent();
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
        Schema::dropIfExists('crawl_reports');
    }
}
