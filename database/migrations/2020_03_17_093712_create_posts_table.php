<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('content');
            $table->text('excerpt');
            $table->string('thumbnail');
            $table->string('slug');
            $table->integer('author');
            $table->integer('status')->default(1);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_experience')->default(false);
            $table->boolean('is_event')->default(false);
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->integer('sort')->default(0);
            $table->integer('view_count')->default(0);
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
        Schema::dropIfExists('posts');
    }
}
