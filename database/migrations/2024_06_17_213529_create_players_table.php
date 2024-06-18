<?php

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Team::class)->constrained()->cascadeOnDelete();
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('vetoed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'team_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
