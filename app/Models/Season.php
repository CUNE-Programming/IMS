<?php

namespace App\Models;

use App\Enums\SeasonPeriod;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Spatie\IcalendarGenerator\Components\Event;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Enums\EventStatus;

/**
 * \App\Models\Season
 * ------------------------
 * This represents a season of a sport.
 * A season is a specific time period where games are played.
 * A season can be divided into 2 periods: registration and games.
 * During the registration period, teams and free agents can sign up to participate in the season.
 * During the games period, teams play games against each other. The season ends when all games have been played.
 * During the games period, a team may pick up a free agent to fill in for a missing player.
 *
 * @property int $id The unique identifier for the season.
 * @property int $variant_id The unique identifier for the variant.
 * @property string $name The name of the season.
 * @property string $description A description of the season. This is used in the flyer for the season.
 * @property Carbon $registration_start The date when registration opens for the season.
 * @property Carbon $registration_end The date when registration closes for the season.
 * @property Carbon $start_date The date when games start for the season.
 * @property Carbon $end_date The date when games end for the season.
 * @property Carbon $created_at The timestamp for when the season was created.
 * @property Carbon $updated_at The timestamp for when the season was last updated.
 * @property-read string $semester
 * @property-read SeasonPeriod $period
 * @property Variant $variant The variant that the season belongs to.
 * @property \Illuminate\Database\Eloquent\Collection<FreeAgent> $freeAgents The free agents for the season.
 * @property \Illuminate\Database\Eloquent\Collection<Team> $teams The teams for the season.
 * @property \Illuminate\Database\Eloquent\Collection<Game> $games The games for the season.
 */
class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        'variant_id',
        'description',
        'start_date',
        'end_date',
        'registration_start',
        'registration_end',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'registration_start' => 'date',
        'registration_end' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::saving(function (Season $season) {
            $season->validateDates();
            $season->name = "{$season->semester} {$season->start_date->year} {$season->variant->sport->name} Season ({$season->variant->name})";
        });
    }

    /* ===== Relationships ===== */

    /**
     * Get the variant that the season belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Variant>
     */
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    /**
     * Get the free agents for the season.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<FreeAgent>
     */
    public function freeAgents()
    {
        return $this->hasMany(FreeAgent::class);
    }

    /**
     * Get the teams for the season.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Team>
     */
    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    /**
     * Get the games for the season.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Game>
     */
    public function games()
    {
        return $this->hasMany(Game::class);
    }

    // Scopes

    /**
     * Scope a query to only include active seasons.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<self>  $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeWhereActive($query)
    {
        return $query
            ->where('registration_start', '<=', now())
            ->where('end_date', '>=', now());
    }

    /**
     * Scope a query to include the maximum team size for the season.
     * This will add a `max_team_size` attribute to the query.
     * This attribute will be the maximum number of players allowed on a team.
     * @param  \Illuminate\Database\Eloquent\Builder<self>  $query
     * @param  int|Season $season
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    protected function scopeWithMaxTeamSize($query)
    {
        return $query->addSelect([
            'max_team_size' => $query
                ->join('variants', 'variants.id', 'seasons.variant_id')
                ->select('max_team_size')
                ->limit(1),
            'seasons.*',
        ]);
    }

    /**
     * Scope a query to include if the given user is a coordinator for the season.
     * @param  \Illuminate\Database\Eloquent\Builder<self>  $query
     * @param  ?User  $user
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    protected function scopeWithCoordinatorStatus($query, ?User $user)
    {
        return $query->addSelect([
            'is_coordinator' => DB::table('coordinators')
                ->leftJoin('seasons', 'coordinators.variant_id', 'seasons.variant_id')
                ->where('coordinators.user_id', $user?->id)
                ->select('coordinators.user_id')
                ->limit(1),
            'seasons.*',
        ]);
    }

    // Accessors and Mutators

    /**
     * Get the current semester for the season.
     */
    protected function semester(): Attribute
    {
        return Attribute::make(
            get: fn () => match (true) {
                in_range($this->start_date->month, 9, 12) => 'Fall',
                in_range($this->start_date->month, 1, 5) => 'Spring',
                default => 'Summer',
            }
        );
    }

    protected function period(): Attribute
    {
        return Attribute::make(
            get: fn () => match (true) {
                now()->isBefore($this->registration_start) => SeasonPeriod::Upcoming(),
                now()->isAfter($this->end_date) => SeasonPeriod::Past(),
                now()->isBetween($this->registration_start, $this->registration_end) => SeasonPeriod::Registration(),
                default => SeasonPeriod::Games(),
            }
        );
    }

    // Methods


    /**
     * Get the iCal stream for the season.
     */
    public function getICalStream()
    {
        $calendar = Calendar::create()
            ->name($this->name . ' Schedule')
            ->description($this->description)
            ->refreshInterval(60);

        $calendar->event(Event::create()
            ->name('Registration Period')
            ->description('The registration period for the season.')
            ->fullDay()
            ->startsAt($this->registration_start)
            ->endsAt($this->registration_end));

            $calendar->event(Event::create()
            ->name('Start of Season')
            ->description('The season starts.')
            ->fullDay()
            ->startsAt($this->start_date));

            $calendar->event(Event::create()
            ->name('End of Season')
            ->description('The season ends.')
            ->fullDay()
            ->startsAt($this->end_date));


        $this->games->filter(fn(Game $game) => !$game->status->isCancelled())->map(fn (Game $game) => Event::create()
            ->name("Game")
            ->description($game->teams()->select('name')->get()->implode('name', ' vs '))
            ->alertMinutesBefore(60, "The game is about to start.")
            ->startsAt($game->scheduled_at)
            ->endsAt($game->scheduled_at->addMinutes($this->variant()->select('average_duration')->first()->average_duration))
        )->each(fn (Event $event) => $calendar->event($event));


        return $calendar->get();
    }

    /**
     * This method validates the dates for the season.
     * The dates must follow the following order:
     * 1. registration_start
     * 2. registration_end
     * 3. start_date
     * 4. end_date
     *
     * Any deviation from this order will result in an exception being thrown.
     *
     * @throws InvalidArgumentException if the dates are not valid.
     */
    private function validateDates(): void
    {
        match (true) {
            $this->end_date->isBefore($this->start_date) => throw new InvalidArgumentException('end_date must be after start_date'),
            $this->registration_end->isBefore($this->registration_start) => throw new InvalidArgumentException('registration_end must be after registration_start'),
            $this->start_date->isBefore($this->registration_start) => throw new InvalidArgumentException('registration_start must be before start_date'),
            $this->start_date->isBefore($this->registration_end) => throw new InvalidArgumentException('registration_end must be before start_date'),
            default => null,
        };
    }
}
