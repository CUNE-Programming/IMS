<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * The GameStatus Enumeration.
 * A Game can have a variety of statuses:
 *
 * @method static self Scheduled()
 * @method static self Postponed()
 * @method static self Cancelled()
 * @method static self Played()
 */
class GameStatus extends Enum {}
