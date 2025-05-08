<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->text('description')->change();
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->text('description')->change();
        });
        Schema::table('product_category_brand', function (Blueprint $table) {
            $table->text('description')->change();
        });
        Schema::table('product_tags', function (Blueprint $table) {
            $table->text('description')->change();
        });
        Schema::table('post_tags', function (Blueprint $table) {
            $table->text('description')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('description')->change();
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->string('description')->change();
        });
        Schema::table('product_category_brand', function (Blueprint $table) {
            $table->string('description')->change();
        });
        Schema::table('product_tags', function (Blueprint $table) {
            $table->string('description')->change();
        });
        Schema::table('post_tags', function (Blueprint $table) {
            $table->string('description')->change();
        });
    }
}
