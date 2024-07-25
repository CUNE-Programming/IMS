<?php

use App\Models\Sport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Sport::class)->constrained()->cascadeOnDelete();
            $table->string('name', 255)->fulltext();
            $table->text('description');
            $table->unsignedtinyInteger('max_number_of_teams');
            $table->unsignedinteger('average_duration');
            $table->unsignedtinyInteger('max_team_size')->nullable();
            $table->unsignedtinyInteger('min_girls')->nullable();
            $table->unsignedtinyInteger('min_boys')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
