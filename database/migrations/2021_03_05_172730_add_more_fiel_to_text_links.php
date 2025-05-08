<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFielToTextLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('text_links', function (Blueprint $table) {
            $table->integer('index')->nullable();
            $table->string('list_id')->nullable();
            $table->boolean('status')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('text_links', function (Blueprint $table) {
            $table->dropColumn('index');
            $table->dropColumn('list_id');
            $table->dropColumn('status');
        });
    }
}
