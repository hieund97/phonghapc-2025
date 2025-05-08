<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug');
            $table->string('thumbnail')->nullable();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->integer('ordering')->nullable()->default(0);
            $table->integer('ordering_menu_top')->nullable()->default(0);
            $table->integer('ordering_menu_home')->nullable()->default(0);
            $table->integer('ordering_menu_bottom')->nullable()->default(0);
            $table->integer('parent_id_menu_top')->nullable()->default(0);
            $table->integer('parent_id_menu_home')->nullable()->default(0);
            $table->integer('parent_id_menu_bottom')->nullable()->default(0);
            $table->boolean('is_menu_top')->nullable()->default(false);
            $table->boolean('is_menu_home')->nullable()->default(false);
            $table->boolean('is_menu_bottom')->nullable()->default(false);
            $table->tinyInteger('level')->nullable()->default(1);
            $table->tinyInteger('status')->nullable()->default(1); // 1 active, 2. inactive
            $table->tinyInteger('type')->nullable()->default(1); // 1 Sản phẩm, 2. Phụ kiện
            $table->integer('parent_id_menu_promotion')->nullable()->default(0);
            $table->boolean('show_on_mobile')->default(false);
            $table->integer('ordering_menu_promotion')->nullable()->default(0);
            $table->boolean('show_on_promotion')->default(false);
            $table->nestedSet();
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
        Schema::dropIfExists('product_categories');
    }
}
