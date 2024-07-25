<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;
use InvalidArgumentException;

/**
 * A Game Team is a pivot model that represents a team's participation in a game.
 * If a team wins a game, the team's score will be greater than the opponent's score.
 * If a score is null that means the game has not been played yet.
 *
 * @property int $id The unique identifier for the game team.
 * @property int $game_id The unique identifier for the game.
 * @property int $team_id The unique identifier for the team.
 * @property ?int $score The score of the team in the game. If null, the game has not been played yet.
 * @property Carbon $created_at The timestamp for when the game team was created.
 * @property Carbon $updated_at The timestamp for when the game team was last updated.
 * @property Team $team The team that the game team belongs to.
 * @property Game $game The game that the game team belongs to.
 */
class GameTeam extends Pivot
{
    use HasFactory;

    public $timestamps = true;
    public $incrementing = true;

    protected $primaryKey = 'id';
    protected $keyType = 'int';

    protected $table = 'game_teams';

    protected $fillable = [
        'game_id',
        'team_id',
        'score',
    ];

    public static function booted()
    {
        static::creating(function (GameTeam $gameTeam) {
            if (! $gameTeam->game->season->is($gameTeam->team->season)) {
                throw new InvalidArgumentException('The team and game do not belong to the same season');
            }
        });
    }

    /* ===== Relationships ===== */

    /**
     * Get the team that the game team belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Team>
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the game that the game team belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Game>
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
