<?php

use App\Models\Game;
use App\Models\GameTeam;
use App\Models\Season;
use App\Models\Team;

describe('Game Team Model', function () {

    it('should create a new game team', function () {
        $season = Season::factory()->create();
        $team = Team::factory()->create([
            'season_id' => $season->id,
        ]);
        $game = Game::factory()->create([
            'season_id' => $season->id,
        ]);
        $gameTeam = GameTeam::factory()->create([
            'game_id' => $game->id,
            'team_id' => $team->id,
        ]);
        expect($gameTeam->id)->toBeInt();
        expect($gameTeam->game_id)->toBeInt();
        expect($gameTeam->team_id)->toBeInt();
        expect($gameTeam->score)->toBeNull();

        $gameTeam->refresh();

        expect($gameTeam->team)->not->toBeNull();
        expect($gameTeam->game)->not->toBeNull();
    });

});
