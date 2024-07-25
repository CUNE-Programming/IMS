<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * The Moderation Status of a model.
 *
 * @method static self Pending()
 * @method static self Approved()
 * @method static self Rejected()
 * @method static self Appealed()
 */
class ModerationStatus extends Enum
{
    //
}
