<?php

use App\Enums\SeasonPeriod;
use App\Models\Season;
use Illuminate\Support\Carbon;

use function Pest\Laravel\assertDatabaseCount;
use function PHPUnit\Framework\assertTrue;

describe('Season', function () {

    it('should create a new season', function () {
        $season = Season::factory()->create();
        expect($season->id)->toBeInt();
        expect($season->name)->toBeString();
        expect($season->start_date)->toBeInstanceOf(Carbon::class);
        expect($season->end_date)->toBeInstanceOf(Carbon::class);
    });

    it('should fail to save a season with an end date before the start date', function () {
        $season = Season::factory()->create([
            'start_date' => now(),
            'end_date' => now()->subDay(),
        ]);
    })->throws(InvalidArgumentException::class);

    it('should return a fall season', function () {
        $season = Season::factory()->create([
            'registration_start' => Carbon::create(2021, 8, 1),
            'registration_end' => Carbon::create(2021, 9, 1),
            'start_date' => Carbon::create(2021, 9, 1),
            'end_date' => Carbon::create(2021, 11, 30),
        ]);
        expect($season->semester)->toBe('Fall');
    });

    it('should return a season as upcoming', function () {
        $season = Season::factory()->create([
            'registration_start' => now()->addDay(),
            'registration_end' => now()->addDays(2),
            'start_date' => now()->addDays(3),
            'end_date' => now()->addDays(5),
        ]);

        assertTrue($season->period->equals(SeasonPeriod::Upcoming()));
    });

    it('should return a season as past', function () {
        $season = Season::factory()->create([
            'registration_start' => now()->subDays(5),
            'registration_end' => now()->subDays(3),
            'start_date' => now()->subDays(2),
            'end_date' => now()->subDay(),
        ]);

        assertTrue($season->period->equals(SeasonPeriod::Past()));
    });

    it('should return a season as registration', function () {
        $season = Season::factory()->create([
            'registration_start' => now()->subDay(),
            'registration_end' => now()->addDay(),
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(5),
        ]);

        assertTrue($season->period->equals(SeasonPeriod::Registration()));
    });

    it('should return a season as games', function () {
        $season = Season::factory()->create([
            'registration_start' => now()->subDays(5),
            'registration_end' => now()->subDays(3),
            'start_date' => now()->subDays(2),
            'end_date' => now()->addDay(),
        ]);

        assertTrue($season->period->equals(SeasonPeriod::Games()));
    });

    it('has variants', function () {
        $season = Season::factory()->create();
        expect($season->variant)->not->toBeNull();
        assertDatabaseCount('variants', 1);
    });

    it('should return the teams that belong to the season', function () {
        $season = Season::factory()->hasTeams(3)->create();
        expect($season->teams)->toHaveCount(3);
    });

    it('should return the games that belong to the season', function () {
        $season = Season::factory()->hasGames(3)->create();
        expect($season->games)->toHaveCount(3);
    });

    it('should return the free agents that belong to the season', function () {
        $season = Season::factory()->hasFreeAgents(3)->create();
        expect($season->freeAgents)->toHaveCount(3);
    });

    it('should return zero active seasons', function () {
        $season = Season::factory()->create([
            'registration_start' => now()->subDays(5),
            'registration_end' => now()->subDays(3),
            'start_date' => now()->subDays(2),
            'end_date' => now()->subDay(),
        ]);
        expect(Season::whereActive()->get())->toHaveCount(0);
    });
});
