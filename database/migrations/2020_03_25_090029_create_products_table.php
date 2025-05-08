<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('suffix')->nullable();
            $table->tinyInteger('type')->default(0);
            $table->integer('price');
            $table->string('hide_price_label', 50)->nullable();
            $table->integer('sale_price')->nullable();
            $table->dateTime('sale_from')->nullable();
            $table->dateTime('sale_to')->nullable();
            $table->boolean('hide_sale_time')->default(false);
            $table->string('serial')->nullable();
            $table->string('warranty')->nullable();
            $table->string('feature_img');
            $table->text('technical_specification')->nullable();
            $table->text('include_in_box')->nullable();
            $table->longText('description');
            $table->text('real_images')->nullable();
            $table->boolean('show_on_top')->default(false);
            $table->boolean('pin_to_top')->default(false);
            $table->string('slug')->unique();
            $table->tinyInteger('status');
            $table->text('status_note')->nullable();
            $table->string('status_note_color', 15)->default('#006699,#9F815C');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('product_category_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('skus')->nullable();
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('products')->onDelete('set null');
            $table->integer('rate_count');
            $table->decimal('rate_star',8,2);
            $table->integer('view_count')->default(0)->nullable();
            $table->timestamps();
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
