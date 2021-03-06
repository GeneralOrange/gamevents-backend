<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Summoner>
 */
class SummonerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'riot_puuid' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'riot_id' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'riot_account_id' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'icon_id' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'level' => $this->faker->integer()
        ];
    }
}
