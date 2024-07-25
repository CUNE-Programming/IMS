<?php

use App\Enums\ClassStanding;
use App\Models\Season;
use App\Models\User;
use App\Services\Gravatar;

describe('User Model', function () {

    it('should create a new user', function () {
        $user = User::factory()->create();
        expect($user->id)->toBeInt();
        expect($user->name)->toBeString();
        expect($user->email)->toBeString();
        expect($user->class_standing)->toBeInstanceOf(ClassStanding::class);
    });

    it('should have zero or more teams', function () {
        $user = User::factory()->hasTeams(3)->create();
        expect($user->teams)->toHaveCount(3);
    });

    it('should have zero or more free agents', function () {
        $user = User::factory()->hasFreeAgents(3)->create();
        expect($user->freeAgents)->toHaveCount(3);
    });

    it('should return the correct gravatar url', function () {
        $user = User::factory()->create();
        $gravatar = new Gravatar;
        $expected = 'https://www.gravatar.com/avatar/' . hash('sha256', strtolower(trim($user->email))) . '?' . http_build_query([
            's' => htmlentities($gravatar->size),
            'd' => htmlentities($gravatar->default_image_type),
        ]);
        expect($user->avatar)->toBe($expected);
    });

    it('should be a free agent in the current season', function () {
        $user = User::factory()->create();
        $season = Season::factory()->create();

        $user->freeAgents()->create([
            'season_id' => $season->id,
        ]);

        expect($user->isFreeAgentIn($season))->toBeTrue();
    });

    it('should not be a free agent in the current season', function () {
        $user = User::factory()->create();
        $season = Season::factory()->create();

        expect($user->isFreeAgentIn($season))->toBeFalse();
    });

    it('should find a user by email', function () {
        $user = User::factory()->create();
        $foundUser = User::findByEmail($user->email);
        expect($foundUser->id)->toBe($user->id);
    });
});
