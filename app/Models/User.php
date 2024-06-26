<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\ClassStanding;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property ClassStanding $class_standing
 * @property bool $is_coordinator
 * @property string $gender
 * @property \Carbon\Carbon|null $email_verified_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<Team> $teams
 * @property-read \Illuminate\Database\Eloquent\Collection<FreeAgent> $free_agents
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
        'class_standing',
        'is_coordinator',
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

    // Relationships

    /**
     * Get the teams that the user is on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Team>
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'players')->using(Player::class);
    }

    public function freeAgents()
    {
        return $this->hasMany(FreeAgent::class);
    }

    // Methods

    /**
     * Return whether a user is a free agent for a given season.
     */
    public function isFreeAgent(Season $season): bool
    {
        return $this->free_agents->where('season_id', $season->id)->isNotEmpty();
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
        ];
    }
}
