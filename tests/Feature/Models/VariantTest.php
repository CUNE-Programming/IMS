<?php

use App\Models\Sport;
use App\Models\Variant;

use function Pest\Laravel\assertDatabaseCount;

// Create Test
test('the variant can be created', function () {
    // Arrange
    $variant = Variant::factory()->make();

    // Act
    $variant->save();
    $variant->refresh();

    // Assert
    expect($variant->exists)->toBeTrue();
    assertDatabaseCount('variants', 1);
    expect($variant->is(Variant::first()))->toBeTrue();
});

// Read Test
test('the variant can be read', function () {
    // Arrange
    Variant::factory()->create();

    // Act

    // Assert
    expect(Variant::first())->not->toBeNull();
});

// Update Test
test('the variant can be updated', function () {
    // Arrange
    $variant = Variant::factory()->create(['name' => 'orig name',
        'description' => 'orig description',
        'max_number_of_teams' => 10,
        'average_duration' => 45,
        'max_team_size' => 7,
        'min_girls' => 2,
        'min_boys' => 3, ]);

    // Act
    $variant->name = 'updated name';
    $variant->description = 'updated description';
    $variant->max_number_of_teams = 15;
    $variant->average_duration = 30;
    $variant->max_team_size = 5;
    $variant->min_girls = 3;
    $variant->min_boys = 1;
    $variant->save();
    $variant->refresh();

    // Assert
    expect($variant->name)->toBe('updated name');
    expect($variant->description)->toBe('updated description');
    expect($variant->max_number_of_teams)->toBe(15);
    expect($variant->average_duration)->toBe(30);
    expect($variant->max_team_size)->toBe(5);
    expect($variant->min_girls)->toBe(3);
    expect($variant->min_boys)->toBe(1);

});

// Delete Test
test('the variant can be deleted', function () {
    // Arrange
    $variant = Variant::factory()->create();

    // Act
    $variant->delete();

    // Assert
    expect(Variant::first())->toBeNull();
});

test('the variant belongs to a sport', function () {
    // Arrange
    $sport = Sport::factory()->create();
    $variant = Variant::factory()->create(['sport_id' => $sport]);

    // Act

    // Assert
    expect($variant->sport->id)->toEqual($sport->id);
});
