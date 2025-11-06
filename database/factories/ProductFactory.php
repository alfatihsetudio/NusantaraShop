<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;

class ProductFactory extends Factory
{
    public function definition()
    {
        $name = $this->faker->unique()->words(3, true);
        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(100,999),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(10000,500000),
            'stock' => $this->faker->numberBetween(1,100),
            'image' => null,
        ];
    }
}
