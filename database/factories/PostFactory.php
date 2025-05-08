<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categories = \App\Models\Category::whereNotNull('parent_id')->get()->pluck('id')->toArray();
        return [
            'product_category_id' => $this->faker->randomElement($categories),
            'title' => $title = $this->faker->unique()->sentence(),
            'content' => $this->faker->paragraphs(5, true),
            'excerpt' => $this->faker->paragraph(),
            'thumbnail' => $this->faker->imageUrl(),
            'slug' => \Illuminate\Support\Str::slug($title),
            'author' => $this->faker->name(),
            'status' => 1,
        ];
    }
}
