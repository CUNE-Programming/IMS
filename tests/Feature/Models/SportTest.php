<?php

use App\Models\Sport;
use Illuminate\Support\Facades\URL;

describe('Sport Model', function () {

    it('should create a new sport', function () {
        $sport = Sport::factory()->create();
        expect($sport->id)->toBeInt();
        expect($sport->name)->toBeString();
        expect(URL::isValidUrl($sport->image))->toBeTrue();
    });

    it('should return a default url when no image is provided', function () {
        $sport = Sport::factory()->noImage()->create();
        expect($sport->image)->toBe('https://upload.wikimedia.org/wikipedia/commons/9/92/Youth-soccer-indiana.jpg');
    });

    it('should return a shortened version of the description', function () {
        $description = fake()->paragraphs(asText: true);
        $sport = Sport::factory()->create(['description' => $description]);
        expect($sport->excerpt)->toBe(str($description)->limit(20)->__toString());
    });

    it('should return the variants that belong to the sport', function () {
        $sport = Sport::factory()->hasVariants(3)->create();
        expect($sport->variants)->toHaveCount(3);
    });

    it('should return no sports when no sports have ongoing seasons', function () {
        $sport = Sport::factory()->create();
        expect(Sport::hasOngoingSeason()->get())->toHaveCount(0);
    });
});
