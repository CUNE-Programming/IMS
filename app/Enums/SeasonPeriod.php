<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * The SeasonPeriod Enumeration.
 * This represents whether the season is in registration or games.
 *
 * @method static self Upcoming()
 * @method static self Registration()
 * @method static self Games()
 * @method static self Past()
 */
class SeasonPeriod extends Enum {}
