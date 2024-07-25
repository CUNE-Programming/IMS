<?php

namespace App\Models\Concerns;

use App\Enums\ModerationStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * This trait is used to add moderation to a model.
 * Moderation operates on a model by allowing a user to approve or reject a model.
 * In addition, the model can be appealed for a second review.
 * If the appeal is successful, the model is approved.
 * If the appeal is unsuccessful, the model is rejected and stays rejected.
 *
 * @property \Illuminate\Support\Carbon|null $approved_at The timestamp for when the model was approved.
 * @property \Illuminate\Support\Carbon|null $rejected_at The timestamp for when the model was rejected.
 * @property string|null $rejected_reason The reason why the model was rejected.
 * @property \Illuminate\Support\Carbon|null $appealed_at The timestamp for when the model was appealed.
 * @property-read bool $can_be_appealed Whether the model can be appealed.
 * @property-read ModerationStatus $status The status of the model.
 *
 * @method bool approve() Approve the model.
 * @method bool reject(string $reason) Reject the model.
 * @method bool appeal() Appeal the rejection of the model.
 */
trait HasModeration
{
    /**
     * Approve the model.
     * This should only be called by the coordinator.
     *
     * @return bool True if the model was approved successfully, false otherwise.
     */
    public function approve(): bool
    {
        $this->approved_at = now();

        return $this->save();
    }

    /**
     * Reject the model.
     * This should only be called by the coordinator.
     *
     * @param  string  $reason  The reason why the model was rejected.
     * @return bool True if the model was rejected successfully, false otherwise.
     */
    public function reject(string $reason): bool
    {
        $this->rejected_at = now();
        $this->rejected_reason = $reason;

        return $this->save();
    }

    /**
     * Appeal the rejection of the model.
     * This should only be called by the user.
     *
     * @return bool True if the appeal was successful, false otherwise.
     */
    public function appeal(): bool
    {
        if (! $this->can_be_appealed) {
            return false;
        }
        $this->appealed_at = now();
        $this->rejected_at = null;
        $this->rejected_reason = '';

        return $this->save();
    }

    /**
     * Get all rejected models.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  The query to filter.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRejected($query)
    {
        return $query->whereNotNull('rejected_at')->whereNull('appealed_at')->whereNull('approved_at');
    }

    /**
     * Get all models that have been appealed.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  The query to filter.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAppealed($query)
    {
        return $query->whereNotNull('appealed_at')->whereNull('rejected_at')->whereNull('approved_at');
    }

    /**
     * Get all models that are pending.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  The query to filter.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->whereNull('rejected_at')->whereNull('approved_at')->whereNull('appealed_at');
    }

    /**
     * Get all models that are approved.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  The query to filter.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_at');
    }

    /**
     * Get if the model can be appealed.
     *
     * @return bool
     */
    protected function canBeAppealed(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->rejected_at and is_null($this->appealed_at);
            },
        );
    }

    /**
     * Get the status of the model.
     *
     * @return ModerationStatus The status of the model.
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match (true) {
                    filled($this->approved_at) => ModerationStatus::Approved(),
                    filled($this->rejected_at) => ModerationStatus::Rejected(),
                    filled($this->appealed_at) => ModerationStatus::Appealed(),
                    default => ModerationStatus::Pending(),
                };
            },
        );
    }
}
