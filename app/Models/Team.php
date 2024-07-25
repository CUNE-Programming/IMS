<?php

namespace App\Models;

use App\Models\Concerns\HasModeration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * A team is a group of players that compete in a season.
 * A team has a name, a season that they are competing in, and a team captain.
 * The team captain points to a player instance, although it is not a foreign key since that
 * would create a circuluar reference.
 * Team names need to be approved by the coordinator before they are accepted.
 * A team can be rejected by the coordinator if the name is inappropriate.
 * A team gets one chance to appeal the rejection, and if the appeal is successful, the team is approved.
 * Otherwise the team is rejected.
 *
 * @property int $id The unique identifier for the team.
 * @property string $name The name of the team. Needs approval from the coordinator before it is accepted.
 * @property int $season_id The unique identifier for the season that the team is competing in.
 * @property int $team_captain_id The player that is the team captain.
 * @property \Illuminate\Support\Carbon|null $created_at The timestamp for when the team was created.
 * @property \Illuminate\Support\Carbon|null $updated_at The timestamp for when the team was last updated.
 * @property Season $season The season that the team is competing in.
 * @property \Illuminate\Database\Eloquent\Collection<User> $players The players that are on the team.
 * @property User $teamCaptain The player that is the team captain.
 */
class Team extends Model
{
    use HasFactory, HasModeration;

    protected $fillable = [
        'name',
        'season_id',
        'team_captain_id',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'appealed_at' => 'datetime',
    ];

    // Methods

    public static function createWithCaptain(array $attributes, User $captain): Team
    {
        return DB::transaction(function () use ($attributes, $captain) {
            /** @var self */
            $team = static::create($attributes);

            $team->teamCaptain()->associate($captain)->save();

            return $team;
        });
    }

    /* ===== Relationships ===== */

    /**
     * Get the season that the team is competing in.
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function teamCaptain()
    {
        return $this->belongsTo(User::class, 'team_captain_id');
    }

    /* ===== Methods ===== */

    /**
     * Pick up a free agent to join the team.
     * A free agent picked up enters like a player on the team, meaning approval and such.
     *
     * @param  FreeAgent  $freeAgent  The free agent to pick up.
     * @return ?Player The player that was created from the free agent, or null if the free agent could not be picked up.
     */
    public function pickUpFreeAgent(FreeAgent $freeAgent): ?Player
    {
        return DB::transaction(function () use ($freeAgent) {
            $player = Player::create([
                'user_id' => $freeAgent->user_id,
                'team_id' => $this->id,
            ]);
            $freeAgent->delete();

            return $player;
        });
    }
}
