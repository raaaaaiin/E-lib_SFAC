<?php

namespace Database\Factories;


use App\Models\VisitorTracking;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitorTrackingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VisitorTracking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween("-12 months")->format('Y-m-d H:i:s');
        $tmp = [];
        foreach (range(0, rand(0, 25)) as $item) {
            VisitorTracking::create([
                //
                "user_agent" => $this->faker->userAgent,
                "refer" => "http://google.com",
                "ip_address" => $this->faker->ipv4,
                'created_at' => $date,
                'updated_at' => $date
            ]);
        }
        return $tmp;
    }
}
