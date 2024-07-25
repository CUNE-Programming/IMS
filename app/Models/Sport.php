<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Sport
 * --------
 * This represents an overall sport in the system.
 * A sport is really just a grouping for a number of variants.
 * For example, "Soccer" is a sport, and "Indoor Soccer" and "Outdoor Soccer" are variants.
 * As such, sports are not directly accessed often.
 *
 * @property int $id The unique identifier for the sport.
 * @property string $name The name of the sport.
 * @property string $description A description of the sport.
 * @property string $image The URL to a picture of the sport.
 * @property-read string $excerpt A shortened version of the description.
 * @property \Illuminate\Support\Carbon $created_at The timestamp for when the sport was created.
 * @property \Illuminate\Support\Carbon $updated_at The timestamp for when the sport was last updated.
 * @property-read \Illuminate\Database\Eloquent\Collection<Variant> $variants The variants that belong to the sport.
 */
class Sport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    protected static function booted()
    {
        static::saved(function (Sport $sport) {
            $sport->variants->each(function ($variant) {
                $variant->seasons->each->save();
            });
        });
    }

    /* ===== Relationships ===== */

    /**
     * Get the variants that belong to the sport.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Variant>
     */
    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }

    /* ===== Scopes ===== */

    /**
     * Scope a query to only include sports that have an ongoing season.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<self>  $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeHasOngoingSeason($query)
    {
        return $query->whereHas('variants', function ($query) {
            return $query->whereHas('seasons', function ($query) {
                return $query->where('registration_start', '<=', now())
                    ->where('end_date', '>=', now());
            });
        });
    }

    /* ===== Accessors and Mutators ===== */

    /**
     * Get the URL to a picture of the sport.
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (blank($value)) {
                    return 'https://upload.wikimedia.org/wikipedia/commons/9/92/Youth-soccer-indiana.jpg';
                }

                return Storage::url($value);
            },
            set: function ($value) {
                if ($this->attributes['image'] === $value) {
                    return;
                }
                if (filled($this->attributes['image'])) {
                    Storage::delete($this->attributes['image']);
                }

                return $value;
            }
        );
    }

    /**
     * Get a shortened version of the description.
     */
    protected function excerpt(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::limit($this->description, 20),
        );
    }
}
