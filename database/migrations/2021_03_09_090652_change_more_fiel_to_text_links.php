<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMoreFielToTextLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('text_links', function (Blueprint $table) {
            $table->json('index')->nullable()->change();
            $table->json('list_id')->nullable()->change();
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
        });
    }
}
