<?php

use App\Models\Player;

use function Pest\Laravel\assertDatabaseCount;

describe('Player Model', function () {

    it('should return the team for the player', function () {
        $player = Player::factory()->create();

        expect($player->team)->not->toBeNull();
        assertDatabaseCount('teams', 1);
    });

    it('should return the user for the player', function () {
        $player = Player::factory()->create();

        expect($player->user)->not->toBeNull();
        assertDatabaseCount('users', 1);
    });

    it('should return the season for the player', function () {
        $player = Player::factory()->create();

        expect($player->season)->not->toBeNull();
        assertDatabaseCount('seasons', 1);
    });

});

describe('Player Moderation', function () {

    it('should return 3 players as pending', function () {
        $players = Player::factory()->count(3)->create();

        $pendingPlayers = Player::pending()->get();

        expect($pendingPlayers)->toHaveCount(3);
    });

    it('should return 3 players as approved', function () {
        $players = Player::factory()->count(3)->create();

        $players->each(function ($player) {
            $player->approve();
        });

        $approvedPlayers = Player::approved()->get();

        expect($approvedPlayers)->toHaveCount(3);
    });

    it('should return 3 players as rejected', function () {
        $players = Player::factory()->count(3)->create();

        $players->each(function ($player) {
            $player->reject(fake()->sentence());
        });

        $rejectedPlayers = Player::rejected()->get();

        expect($rejectedPlayers)->toHaveCount(3);
    });

    it('should return 3 players as appealed', function () {
        $players = Player::factory()->count(3)->create();

        $players->each(function ($player) {
            $player->reject(fake()->sentence());
        });

        $players->each(function ($player) {
            $player->appeal();
        });

        $appealedPlayers = Player::appealed()->get();

        expect($appealedPlayers)->toHaveCount(3);
    });
});
