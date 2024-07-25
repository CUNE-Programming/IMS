<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * The Coordinator model handles the relationship between the a user and a sport variant.
 * Users who are on this table are considered coordinators for the variant they are assigned to.
 * Coordinators get certain privileges to schedule games and start new seasons.
 *
 * @property int $id The unique identifier for the coordinator.
 * @property int $user_id The unique identifier for the user.
 * @property int $variant_id The unique identifier for the variant.
 * @property \Carbon\Carbon|null $created_at The timestamp for when the coordinator was created.
 * @property \Carbon\Carbon|null $updated_at The timestamp for when the coordinator was last updated.
 * @property User $user The user that is a coordinator.
 * @property Variant $variant The variant that the coordinator is assigned to.
 */
class Coordinator extends Pivot
{
    use HasFactory;

    public $timestamps = true;
    public $incrementing = true;

    protected $primaryKey = 'id';
    protected $keyType = 'int';

    protected $table = 'coordinators';

    protected $fillable = [
        'user_id',
        'variant_id',
    ];

    /* ===== Relationships ===== */

    /**
     * Get the user that is a coordinator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the variant that the coordinator is assigned to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Variant>
     */
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
