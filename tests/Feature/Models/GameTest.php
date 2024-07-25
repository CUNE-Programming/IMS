<?php

use App\Enums\GameStatus;
use App\Models\Game;
use Illuminate\Support\Carbon;

use function Pest\Laravel\assertDatabaseCount;
use function PHPUnit\Framework\assertTrue;

describe('Game Model', function () {

    it('should create a new game', function () {
        $game = Game::factory()->create();
        expect($game->id)->toBeInt();
        expect($game->season_id)->toBeInt();
        expect($game->scheduled_at)->toBeInstanceOf(Carbon::class);
        expect($game->postponed_at)->toBeNull();
        expect($game->cancelled_at)->toBeNull();
        expect($game->played_at)->toBeNull();
        assertTrue($game->status->equals(GameStatus::Scheduled()));
    });

    it('should get the season for the game', function () {
        $game = Game::factory()->create();
        expect($game->season)->not->toBeNull();
        assertDatabaseCount('seasons', 1);
    });

    it('should get the teams for the game', function () {
        $game = Game::factory()->create();
        $game->teams()->create([
            'name' => 'Team 1',
            'season_id' => $game->season_id,
        ]);
        $game->teams()->create([
            'name' => 'Team 2',
            'season_id' => $game->season_id,
        ]);
        $teams = $game->teams;
        expect($teams)->not->toBeNull();
        assertDatabaseCount('teams', 2);
    });

    it('should postpone the game', function () {
        $game = Game::factory()->create();
        $game->postpone(now()->addDay());
        expect($game->postponed_at)->toBeInstanceOf(Carbon::class);
        $game->refresh();
        assertTrue($game->status->equals(GameStatus::Postponed()));
    });

    it('should cancel the game', function () {
        $game = Game::factory()->create();
        $game->cancel();
        $game->refresh();
        expect($game->cancelled_at)->toBeInstanceOf(Carbon::class);
        assertTrue($game->status->equals(GameStatus::Cancelled()));
    });

    it('should record a game', function () {
        $game = Game::factory()->create();
        $team1 = $game->teams()->create([
            'name' => 'Team 1',
            'season_id' => $game->season_id,
        ]);
        $team2 = $game->teams()->create([
            'name' => 'Team 2',
            'season_id' => $game->season_id,
        ]);

        $game->recordAsPlayed(collect([
            [$team1, 1],
            [$team2, 2],
        ]));

        $game->refresh();

        expect($game->played_at)->toBeInstanceOf(Carbon::class);
        expect($game->teams->first()->pivot->score)->toBe(1);
        expect($game->teams->last()->pivot->score)->toBe(2);
        expect($game->status->equals(GameStatus::Played()))->toBeTrue();
        expect($game->winners->first()->id)->toBe($team2->id);
    });

});
