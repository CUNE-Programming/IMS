<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameTeams>
 */
class GameTeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'game_id' => Game::factory(),
            'team_id' => Team::factory(),
        ];
    }

    /**
     * Indicate the score of the team in the game.
     */
    public function withScore(int $score): self
    {
        return $this->state(fn (array $attributes) => ['score' => $score]);
    }
}
