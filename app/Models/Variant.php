<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $max_number_of_teams
 * @property int $average_duration
 * @property int $max_team_size
 * @property int $min_girls
 * @property int $min_boys
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Sport $sport
 * @property-read \Illuminate\Database\Eloquent\Collection<Season> $seasons
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
        'name',
        'description',
        'max_number_of_teams',
        'average_duration',
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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }
}
