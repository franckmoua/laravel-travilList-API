<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->city;
        $lat = $this->faker->latitude;
        $lng = $this->faker->longitude;
        
        return [
            'name' => $name,
            'lat' => $lat,
            'lng' => $lng,
            'slug'=> Str::slug($name, '-')
        ];
    }
}