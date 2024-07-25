<?php

use App\Enums\ModerationStatus;
use App\Models\Season;
use App\Models\Team;
use App\Models\User;

use function Pest\Laravel\assertDatabaseCount;
use function PHPUnit\Framework\assertTrue;

describe('Team Model', function () {

    it('should return the correct team name', function () {
        $team = Team::factory()->create();

        expect($team->name)->toBe($team->name);
    });

    it('should return the correct team season', function () {
        $team = Team::factory()->create();

        expect($team->season)->not->toBeNull();
        assertDatabaseCount('seasons', 1);
    });

    it('should return a team with 3 players', function () {
        $team = Team::factory()->hasPlayers(3)->create();

        expect($team->players)->toHaveCount(3);
        assertDatabaseCount('players', 3);
    });

    it('should create a team with a captain', function () {
        $captain = User::factory()->create();
        $teamName = fake()->word();
        $team = Team::createWithCaptain([
            'name' => $teamName,
            'season_id' => Season::factory()->create()->id,
        ], $captain);

        expect($team->teamCaptain->is($captain))->toBeTrue();
    });
});

describe('Team Moderation', function () {

    it('should default a team with a pending status', function () {
        $team = Team::factory()->create();

        assertTrue($team->status->equals(ModerationStatus::Pending()));
    });

    it('should approve a team', function () {
        $team = Team::factory()->create();

        $team->approve();

        assertTrue($team->status->equals(ModerationStatus::Approved()));
    });

    it('should reject a team', function () {
        $team = Team::factory()->create();
        $reason = fake()->sentence();

        $team->reject($reason);

        assertTrue($team->status->equals(ModerationStatus::Rejected()));

        expect($team->rejected_reason)->toBe($reason);
    });

    it('should appeal a team', function () {
        $team = Team::factory()->create();
        $team->reject(fake()->sentence());
        $team->appeal();

        assertTrue($team->status->equals(ModerationStatus::Appealed()));
    });

    it('should reject a team that has been appealed', function () {
        $team = Team::factory()->create();
        $team->reject(fake()->sentence());
        $team->appeal();
        $reason = fake()->sentence();

        $team->reject($reason);

        assertTrue($team->status->equals(ModerationStatus::Rejected()));
        expect($team->rejected_reason)->toBe($reason);
    });

    it('should allow a team to be appealed', function () {
        $team = Team::factory()->create();
        $team->reject(fake()->sentence());

        expect($team->can_be_appealed)->toBeTrue();
    });

    it('should not allow a team to be appealed', function () {
        $team = Team::factory()->create();
        $team->reject(fake()->sentence());
        $team->appeal();

        expect($team->can_be_appealed)->toBeFalse();
    });
});
