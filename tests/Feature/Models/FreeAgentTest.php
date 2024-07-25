<?php

use App\Models\FreeAgent;
use Illuminate\Support\Carbon;

describe('Free Agent', function () {

    it('should create a new free agent', function () {
        $freeAgent = FreeAgent::factory()->create();
        expect($freeAgent->id)->toBeInt();
        expect($freeAgent->user_id)->toBeInt();
        expect($freeAgent->season_id)->toBeInt();
        expect($freeAgent->created_at)->toBeInstanceOf(Carbon::class);
        expect($freeAgent->updated_at)->toBeInstanceOf(Carbon::class);
    });

});
