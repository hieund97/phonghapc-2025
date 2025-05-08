<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFollowCrawlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crawl_reports', function (Blueprint $table) {
            $table->integer('follow')->default(0)->comment('1.Follow, 0. Unfollow');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crawl_reports', function (Blueprint $table) {
            $table->dropColumn('follow');
        });
    }
}
