<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * The FreeAgent model handles the relationship between a user and a season.
 * A user can be a free agent for a season if they are not on a team.
 * Free agents are able to be picked up by teams during the games period of a season.
 * If a team picks up a free agent, the free agent becomes a player on the team and the free agent record is removed.
 *
 * @property int $id The unique identifier for the free agent.
 * @property int $user_id The unique identifier for the user.
 * @property int $season_id The unique identifier for the season.
 * @property \Illuminate\Support\Carbon $created_at The timestamp for when the free agent was created.
 * @property \Illuminate\Support\Carbon $updated_at The timestamp for when the free agent was last updated.
 * @property User $user The user that is a free agent.
 * @property Season $season The season that the free agent is participating in.
 */
class FreeAgent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'season_id',
    ];

    /* ===== Relationships ===== */

    /**
     * Get the user that is a free agent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the season that the free agent is participating in.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Season>
     */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }
}
