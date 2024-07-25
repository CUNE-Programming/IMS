<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A Variant is a specific type of sport that can be played.
 * A variant has a name, description, and other attributes that define how the sport is played.
 * A sport can have many variants, and a variant can have many seasons, however only one
 * season can be active at a time.
 *
 * @property int $id The unique identifier for the variant.
 * @property string $name The name of the variant.
 * @property string $description A description of the variant.
 * @property int $max_number_of_teams The maximum number of teams that can participate in the variant per game.
 * @property int $average_duration The average duration of a game in minutes.
 * @property int $max_team_size The maximum number of players that can be on a team.
 * @property ?int $min_girls The minimum number of girls (defined by a gender of Female) that must be on a team.
 * @property ?int $min_boys The minimum number of boys (defined by a gender of Male) that must be on a team.
 * @property \Carbon\Carbon $created_at The timestamp for when the variant was created.
 * @property \Carbon\Carbon $updated_at The timestamp for when the variant was last updated.
 * @property Sport $sport The sport that the variant belongs to.
 * @property-read \Illuminate\Database\Eloquent\Collection<Season> $seasons The seasons that belong to the variant.
 * @property-read Season $active_season The active season for the variant. There can only be one active season at a time.
 */
class Variant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sport_id',
        'name',
        'description',
        'max_number_of_teams',
        'average_duration',
        'max_team_size',
        'min_girls',
        'min_boys',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'max_number_of_teams' => 'integer',
        'average_duration' => 'integer',
        'max_team_size' => 'integer',
        'min_girls' => 'integer',
        'min_boys' => 'integer',
    ];

    protected static function booted()
    {
        static::saved(function (Variant $variant) {
            $variant->seasons->each->save();
        });
    }

    /* ===== Relationships ===== */

    /**
     * Get the sport that the variant belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Sport>
     */
    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }

    /**
     * Get the seasons that belong to the variant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Season>
     */
    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    /**
     * Get the coordinators that are assigned to the variant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User>
     */
    public function coordinators()
    {
        return $this->belongsToMany(User::class, 'coordinators')->using(Coordinator::class)->withTimestamps();
    }

    /* ===== Accessors and Mutators ===== */

    /**
     * Get the active season for the variant. There can only be one active season at a time.
     *
     * @return ?Season
     */
    public function activeSeason(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->seasons()->whereActive()->first(),
        );
    }

    /**
     * Determine whether the variant has an active season.
     *
     * @return bool
     */
    public function hasActiveSeason()
    {
            return ! is_null($this->active_season);
    }

    /**
     * Append the active season to the variant.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<self>  $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeWithHasActiveSeason($query)
    {
        return $query->addSelect(['has_active_season' => Season::query()
            ->whereColumn('variant_id', 'variants.id')
            ->whereActive()
            ->selectRaw('count(*)'),
        ]);
    }

    /* ===== Scopes ===== */

    /**
     * Get the variants that have an active season.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<self>  $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeHasActiveSeason($query)
    {
        return $query->whereHas('seasons', fn ($query) => $query->whereActive());
    }

    /**
     * Get the variants who the user is a coordinator for
     *
     * @param  \Illuminate\Database\Eloquent\Builder<self>  $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeCoordinatorFor($query, User $user)
    {
        return $query->whereHas('coordinators', fn ($query) => $query->where('user_id', $user->id));
    }

    /* ===== Methods ===== */

    /**
     * Determine whether a user is a coordinator for the variant.
     */
    public function isCoordinator(User $user): bool
    {
        return $this->coordinators()->where('user_id', $user->id)->exists();
    }

    /**
     * Add a new coordinator to the variant.
     *
     * @return ?Coordinator
     */
    public function addCoordinator(User $user): ?Coordinator
    {
        if ($this->isCoordinator($user)) {
            return null;
        }

        return Coordinator::create([
            'user_id' => $user->id,
            'variant_id' => $this->id,
        ]);
    }

    /**
     * Remove a coordinator from the variant.
     */
    public function removeCoordinator(User $user): bool
    {
        return $this->coordinators()->where('user_id', $user->id)->delete();
    }
}
