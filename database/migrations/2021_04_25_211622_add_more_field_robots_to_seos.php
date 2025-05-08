<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldRobotsToSeos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seos', function (Blueprint $table) {
            $table->boolean('index')->default(false);
            $table->boolean('nofollow')->default(false);
            $table->boolean('noimageindex')->default(false);
            $table->boolean('noindex')->default(false);
            $table->boolean('noarchive')->default(false);
            $table->boolean('nosnippet')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seos', function (Blueprint $table) {
            $table->dropColumn('index');
            $table->dropColumn('nofollow');
            $table->dropColumn('noimageindex');
            $table->dropColumn('noindex');
            $table->dropColumn('noarchive');
            $table->dropColumn('nosnippet');
        });
    }
}
