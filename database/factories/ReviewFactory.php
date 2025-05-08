<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->title,
            'body'=>$this->faker->text,
            'user_id'=>0,
            'product_id'=>Product::,
            'rating',
            'approved',
            'count_like',
            'count_dislike',
            'publish_at',
            'full_name',
            'email',
            'phone_number',
            'file'
        ];
    }
}
