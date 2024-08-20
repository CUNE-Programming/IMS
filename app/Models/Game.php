<?php

namespace App\Models;

use App\Enums\GameStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * A Game is a scheduled event between two or more teams.
 * A game is part of a season and has a status.
 * A game can be postponed to a later date if needed.
 *
 * @property int $id The unique identifier for the game.
 * @property int $season_id The unique identifier for the season.
 * @property Carbon $scheduled_at The timestamp for when the game is scheduled to be played.
 * @property ?Carbon $postponed_at The timestamp for when the game was postponed.
 * @property ?Carbon $cancelled_at The timestamp for when the game was cancelled.
 * @property ?Carbon $played_at The timestamp for when the game was played.
 * @property Carbon $created_at The timestamp for when the game was created.
 * @property Carbon $updated_at The timestamp for when the game was last updated.
 * @property Season $season The season that the game belongs to.
 * @property-read GameStatus $status The status of the game.
 * @property-read ?\Illuminate\Database\Eloquent\Collection<Team> $winners The team that won the game.
 * @property-read \Illuminate\Database\Eloquent\Collection<Team> $teams The teams that are playing in the game.
 */
class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'season_id',
        'scheduled_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'postponed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'played_at' => 'datetime',
    ];

    /* ===== Relationships ===== */

    /**
     * Get the season that the game belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Season>
     */
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * Get the teams that are playing in the game.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Team>
     */
    public function teams()
    {
        return $this
            ->belongsToMany(Team::class, 'game_teams')
            ->using(GameTeam::class)
            ->withTimestamps()
            ->withPivot('score');
    }

    /* ===== Methods ===== */

    /**
     * Postpone the game to a later date.
     *
     * @param  Carbon  $postponed_at  The new date and time for the game.
     * @return bool True if the game was postponed, false otherwise.
     */
    public function postpone(Carbon $postponed_at): bool
    {
        if ($this->status->isScheduled()) {
            return DB::transaction(function () use ($postponed_at) {
                $this->scheduled_at = $postponed_at;
                $this->postponed_at = now();

                return $this->save();
            });
        }

        return false;
    }

    /**
     * Cancel the game.
     *
     * @return bool True if the game was cancelled, false otherwise.
     */
    public function cancel(): bool
    {
        if (!$this->status->isCancelled()) {
            return DB::transaction(function () {
                $this->cancelled_at = now();

                return $this->save();
            });
        }

        return false;
    }

    /**
     * Record a game as played.
     *
     * @param  $scores  The scores for each team. It consists of a tuple of team and score.
     * @return bool True if the game was recorded as played, false otherwise.
     */
    public function recordAsPlayed($scores): bool
    {
        if ($this->status->isScheduled()) {
            return DB::transaction(function () use ($scores) {
                $this->played_at = now();
                $scores->each(function ($pair) {
                    $team = $pair[0];
                    $score = $pair[1];
                    GameTeam::where('game_id', $this->id)
                        ->where('team_id', $team?->id ?? $team)
                        ->update(['score' => $score]);
                });

                return $this->save();
            });
        }

        return false;
    }

    public static function createWithTeams($teams, array $attributes): static
    {
        return DB::transaction(function () use ($teams, $attributes) {
            $game = new static($attributes);
            $game->save();
            $game->teams()->attach($teams);

            return $game;
        });
    }

    /* ===== Accessors and Mutators ===== */

    /**
     * Get the status of the game.
     *
     * @return GameStatus The status of the game.
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn () => match (true) {
                ! is_null($this->cancelled_at) => GameStatus::Cancelled(),
                ! is_null($this->played_at) => GameStatus::Played(),
                ! is_null($this->postponed_at) => GameStatus::Postponed(),
                default => GameStatus::Scheduled(),
            },
        );
    }

    /**
     * Get the winner(s) of the game.
     * A Winner is defined as the team with the highest score.
     * A winner is only determined if the game has been played.
     * If some teams have the same score, then all tied teams are winners.
     *
     * @return ?\Illuminate\Database\Eloquent\Collection<Team> The team that won the game.
     */
    protected function winners(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->status->equals(GameStatus::Played())) {
                    return null;
                }

                $maxScore = $this->teams()->withPivot('score')->max('score');

                return $this->teams()->wherePivot('score', $maxScore)->get();
            }
        );
    }

}
