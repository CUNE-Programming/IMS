<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use InvalidArgumentException;

/**
 * \App\Models\Season
 * ------------------------
 * This represents a season of a sport.
 *
 * @property int $id
 * @property int $sport_id
 * @property int $variant_id
 * @property string $name
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property Carbon $registration_start
 * @property Carbon $registration_end
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read string $semester
 * @property Sport $sport
 * @property Variant $variant
 * @property-read bool $is_active
 */
class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        'sport_id',
        'variant_id',
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

    public static function booted()
    {
        static::saving(function (Season $season) {
            $season->validateDates();
            $season->name = "{$season->semester} {$season->start_date->year} {$season->sport->name} Season ({$season->variant->name})";
        });
    }

    public function isActive(): Attribute
    {
        return Attribute::make(
            get: function () {
                $now = now();

                return $now->isBefore($this->end_date) and $now->isAfter($this->registration_start);
            }
        );
    }

    // Accessors and Mutators

    public function semester(): Attribute
    {
        return Attribute::make(
            get: function () {
                $start_date = $this->start_date;
                $end_date = $this->end_date;

                return match (true) {
                    $start_date->month >= 9 && $end_date->month <= 12 => 'Fall',
                    $start_date->month >= 1 && $end_date->month <= 5 => 'Spring',
                    default => 'Summer',
                };
            }
        );
    }

    // Relationships

    /**
     * Get the sport that the season belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Sport>
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

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

    // Scopes

    public function scopeFilterBySportName($query, string $sport_name)
    {
        return $query->whereHas('sport', function ($query) use ($sport_name) {
            $query->where('name', 'like', "%{$sport_name}%");
        });
    }

    // Methods

    private function validateDates(): void
    {
        if ($this->end_date->isBefore($this->start_date)) {
            throw new InvalidArgumentException('end_date must be after start_date');
        }
        if ($this->registration_end->isBefore($this->registration_start)) {
            throw new InvalidArgumentException('registration_end must be after registration_start');
        }
        if ($this->registration_start->isAfter($this->start_date)) {
            throw new InvalidArgumentException('registration_start must be before start_date');
        }
        if ($this->registration_end->isAfter($this->start_date)) {
            throw new InvalidArgumentException('registration_end must be before end_date');
        }
    }
}
