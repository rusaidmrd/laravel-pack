<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Database\Factories\Helpers\FactoryHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'user_id' => FactoryHelper::getRandomModelId(User::class),
            'category_id' => FactoryHelper::getRandomModelId(Category::class),
            'body' => []
        ];
    }
}
