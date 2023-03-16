<?php

namespace Database\Factories;


use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Place::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        
        $name = $this->faker->city;
        $lat = $this->faker->numberBetween(0, 100);
        $lng = $this->faker->numberBetween(0, 100);
        return [
            'name' => $name,
            'lat' => $lat,
            'lng' => $lng,
            'location_id' => 8,
            'visited'=> 0,
           
        ];
    }
}