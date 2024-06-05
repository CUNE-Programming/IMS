<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Sport
 * --------
 * This represents an overall sport in the system.
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $picture
 * @property-read string $excerpt
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Sport extends Model
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
        'picture',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function picture(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $value ?? 'https://upload.wikimedia.org/wikipedia/commons/9/92/Youth-soccer-indiana.jpg';
            },
        );
    }

    public function excerpt(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::limit($this->description, 20),
        );
    }
}
