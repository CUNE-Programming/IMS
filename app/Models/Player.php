<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

/**
 * \App\Models\Player
 * -------------------
 *
 * @property int $id
 * @property int $user_id
 * @property int $team_id
 * @property \Carbon\Carbon|null $approved_at
 * @property \Carbon\Carbon|null $vetoed_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read bool $approved
 * @property-read bool $vetoed
 * @property-read \App\Models\Team $team
 * @property-read \App\Models\User $user
 */
class Player extends Model
{
    use AsPivot, HasFactory;

    protected $table = 'players';

    protected $fillable = [
        'user_id',
        'team_id',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'vetoed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Accessors & Mutators

    public function approved(): Attribute
    {
        return Attribute::make(
            get: fn () => (bool) $this->approved_at,
        );
    }

    public function vetoed(): Attribute
    {
        return Attribute::make(
            get: fn () => (bool) $this->vetoed_at,
        );
    }

    // Relationships

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

    // Scopes

    /**
     * Scope a query to only include players that are not approved or vetoed.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<self>  $query
     */
    public function scopeIsPending($query)
    {
        return $query->whereNull('approved_at')->whereNull('vetoed_at');
    }

    // Custom Methods

    public function veto(User $user)
    {
        if ($user->is_coordinator and is_null($this->approved_at)) {
            $this->vetoed_at = now();

            return $this->save();
        }

        return false;
    }

    public function approve(User $user)
    {
        if ($user->is_coordinator and is_null($this->vetoed_at)) {
            $this->approved_at = now();

            return $this->save();
        }

        return false;
    }
}
