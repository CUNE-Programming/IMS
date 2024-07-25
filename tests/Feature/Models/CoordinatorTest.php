<?php

use App\Models\Coordinator;
use Illuminate\Support\Carbon;

it('should create a new coordinator', function () {
    $coordinator = Coordinator::factory()->create();
    expect($coordinator->id)->toBeInt();
    expect($coordinator->user_id)->toBeInt();
    expect($coordinator->variant_id)->toBeInt();
    expect($coordinator->created_at)->toBeInstanceOf(Carbon::class);
    expect($coordinator->updated_at)->toBeInstanceOf(Carbon::class);

    $coordinator->refresh();

    expect($coordinator->user)->not->toBeNull();
    expect($coordinator->variant)->not->toBeNull();
});
