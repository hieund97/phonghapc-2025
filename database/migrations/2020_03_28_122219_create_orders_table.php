<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id');
            $table->bigInteger('customer_id')->nullable();
            $table->string('customer_name');
            $table->string('customer_mobile');
            $table->string('customer_address');
            $table->text('customer_note')->nullable();
            $table->string('note')->nullable();
            $table->integer('total_price'); // tổng giá mua
            $table->string('extra_name')->nullable(); // tên phụ kiện ko trong trong sản phẩm
            $table->integer('extra_price')->nullable()->default(0); // giá mua thêm phụ kiện 
            $table->integer('total_payment_price'); // giá khách phải trả cuối cùng
            $table->string('coupon_code')->nullable();
            $table->string('thumbnail')->nullable();
            $table->tinyInteger('status')->default(2); // 1. deleted, 2 new, 3.processing 4.cancel 5. success  
            $table->string('customer_id_card')->nullable();
            $table->string('customer_id_card_image')->nullable();
            $table->integer('customer_amount_installment')->nullable();
            $table->string('provider_order_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('provider_message')->nullable();;
            $table->string('customer_email')->nullable();
            $table->integer('bundle_saving')->nullable();
           
            $table->timestamps();
        });
        Schema::create('order_products', function (Blueprint $table) {
            $table->bigInteger('order_id');
            $table->bigInteger('product_id');
            $table->bigInteger('customer_id')->nullable(); // Id người mua
            $table->integer('amount')->default(1);
            $table->integer('price');
            $table->integer('total_price');
            $table->string('note')->nullable();
            $table->string('warranty_name')->nullable();
            $table->integer('warranty_price')->nullable();
            $table->unique(['order_id', 'product_id']);
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
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_products');
    }
}
