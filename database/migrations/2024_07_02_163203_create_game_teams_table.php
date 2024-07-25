<?php

use App\Models\Game;
use App\Models\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Team::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Game::class)->constrained()->cascadeOnDelete();
            $table->bigInteger('score')->nullable();
            $table->timestamps();

            $table->unique(['team_id', 'game_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_teams');
    }
};
