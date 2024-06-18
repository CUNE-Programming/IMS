<?php

use App\Models\Season;

use function Pest\Laravel\assertDatabaseCount;

// Create Test
test('the season can be created', function () {
    // Arrange
    $season = Season::factory()->make();

    // Act
    $season->save();
    $season->refresh();

    // Assert
    expect($season->exists)->toBeTrue();
    assertDatabaseCount('seasons', 1);
    expect($season->is(Season::first()))->toBeTrue();
});

// Read Test
test('the season can be read', function () {
    // Arrange
    Season::factory()->create();

    // Act

    // Assert
    expect(Season::first())->not->toBeNull();
});

test('the season name is generated correctly', function () {
    $season = Season::factory()->forSport(['name' => 'Basketball'])->forVariant(['name' => '3-on-3'])->create([
        'start_date' => '2021-01-01',
        'end_date' => '2021-05-01',
        'registration_start' => '2020-12-01',
        'registration_end' => '2020-12-31',
    ]);
    $expected_season_name = 'Spring 2021 Basketball Season (3-on-3)';

    expect($season->name)->toBe($expected_season_name);
});

test('the season cannot have an end date before the start date', function () {
    Season::factory()->create([
        'start_date' => '2021-01-01',
        'end_date' => '2020-12-31',
    ]);
})->throws(\InvalidArgumentException::class);

test('the season is active', function () {
    $season = Season::factory()->create([
        'start_date' => '2021-01-01',
        'end_date' => '2021-05-01',
        'registration_start' => '2020-12-01',
        'registration_end' => '2020-12-31',
    ]);
    expect($season->is_active)->toBeFalse();
});
