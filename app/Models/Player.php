<?php

namespace App\Models;

use App\Models\Concerns\HasModeration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * A Player is a user that is on a team.
 * A player represents a user that is on a team for a season.
 * A player must be approved by a coordinator to be on a team.
 * A player can be rejected by a coordinator.
 * A team or player can appeal a rejection, and if the appeal is successful, the player is approved.
 * Otherwise the player is rejected.
 * If a player is pending for more than 3 days, the player is automatically approved.
 *
 * @property int $id The unique identifier for the player.
 * @property int $user_id The unique identifier for the user.
 * @property int $team_id The unique identifier for the team.
 * @property \Illuminate\Support\Carbon|null $created_at The timestamp for when the player was created.
 * @property \Illuminate\Support\Carbon|null $updated_at The timestamp for when the player was last updated.
 * @property-read Team $team The team that the player is on.
 * @property-read User $user The user that is a player.
 * @property Season $season The season that the player is on.
 */
class Player extends Pivot
{
    use HasFactory, HasModeration;

    public $timestamps = true;
    public $incrementing = true;

    protected $keyType = 'int';
    protected $primaryKey = 'id';

    protected $table = 'players';

    protected $fillable = [
        'user_id',
        'team_id',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'appealed_at' => 'datetime',
    ];

    /* ===== Relationships ===== */

    /**
     * Get the team that the player is on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Team>
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the season that the player is on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough<Season>
     */
    public function season()
    {
        return $this->hasOneThrough(Season::class, Team::class, 'id', 'id', 'team_id', 'season_id');
    }

    /**
     * Get the user that the player is.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
