<?php

use App\Enums\ModerationStatus;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;

use function Pest\Laravel\artisan;
use function PHPUnit\Framework\assertTrue;

it('should approve all pending players for currently active seasons', function () {
    $season = Season::factory()->create();
    $team = Team::factory()->create([
        'season_id' => $season->id,
    ]);
    $players = Player::factory()->count(3)->create([
        'team_id' => $team->id,
        'created_at' => now()->subDays(4),
    ]);

    $players->each(function ($player) {
        expect($player->status->equals(ModerationStatus::Pending()))->toBeTrue();
    });

    artisan('app:approve-pending-players')
        ->assertExitCode(0);

    $players->each(function ($player) {
        $player->refresh();
        assertTrue($player->status->equals(ModerationStatus::Approved()));
    });
});
