<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * \App\Models\Team
 * ------------------
 *
 * @property int $id
 * @property string $name
 * @property int $season_id
 * @property int|null $team_captain_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \App\Models\Season $season
 * @property \Illuminate\Database\Eloquent\Collection<User> $players
 * @property \App\Models\Player $teamCaptain
 */
class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'season_id',
        'team_captain_id',
    ];

    // Methods

    public static function createWithCaptain(array $attributes, User $captain): Team
    {
        $team = static::create($attributes);
        $team->teamCaptain()->create([
            'user_id' => $captain->id,
        ]);
        $team->teamCaptain->approve();

        return $team;
    }

    /**
     * Get the team captain for the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Season>
     */
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * Get the players on the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User>
     */
    public function players()
    {
        return $this->belongsToMany(User::class, 'players')->using(Player::class);
    }

    /**
     * Get the team captain for the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Player>
     */
    public function teamCaptain()
    {
        return $this->belongsTo(Player::class, 'team_captain_id');
    }
}
