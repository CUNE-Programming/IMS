<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\ClassStanding;
use App\Enums\Gender;
use App\Mail\Auth\LoginMail;
use App\Services\Gravatar;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

/**
 * The User model represents a user on the platform.
 * Users are students who use the platform, admins who manage the platform, and coordinators who manage sports variants.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone_number
 * @property ClassStanding $class_standing
 * @property Gender $gender
 * @property \Carbon\Carbon|null $email_verified_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<Team> $teams
 * @property-read \Illuminate\Database\Eloquent\Collection<FreeAgent> $freeAgents
 * @property-read string $avatar
 * @property bool $is_admin
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'class_standing',
        'gender',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * Get a user by their email address.
     *
     * @return ?User
     */
    public static function findByEmail(string $email): ?User
    {
        return static::where('email', $email)->first();
    }

    // Relationships

    /**
     * Get the teams that the user is on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Team>
     */
    public function teams()
    {
        return $this
            ->belongsToMany(Team::class, 'players')
            ->using(Player::class)
            ->withTimestamps()
            ->withPivot(['approved_at', 'rejected_at', 'rejected_reason', 'appealed_at']);
    }

    public function freeAgents()
    {
        return $this->hasMany(FreeAgent::class);
    }

    public function coordinators()
    {
        return $this->hasMany(Coordinator::class);
    }

    /* ===== Accessors and Mutators ===== */

    public function avatar(): Attribute
    {
        return Attribute::make(
            get: function () {
                return (new Gravatar)->get($this->email);
            },
        );
    }

    // Methods

    /**
     * Return whether a user is a free agent for a given season.
     */
    public function isFreeAgentIn(Season $season): bool
    {
        return $this->freeAgents()->where('season_id', $season->id)->exists();
    }

    /**
     * Send a login email to the user.
     *
     * @param  string  $routeName  The name of the route to send in the email.
     * @param  bool  $sendNow  Whether to send the email immediately or queue it.
     */
    public function sendLoginMail(string $routeName, bool $sendNow = false)
    {
        return Mail::to($this)->{$sendNow ? 'send' : 'queue'}(new LoginMail($this, $routeName));
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_coordinator' => 'boolean',
            'class_standing' => ClassStanding::class,
            'gender' => Gender::class,
        ];
    }

    public function scopeWhereCoordinator($query)
    {
        return $query->whereHas('coordinators');
    }
}
