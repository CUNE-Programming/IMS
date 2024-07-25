<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * The class standing enum.
 *
 * This enum represents all possible class standings for
 * a student on the platform.
 *
 * @method static self Freshman()
 * @method static self Sophomore()
 * @method static self Junior()
 * @method static self Senior()
 * @method static self SuperSenior()
 * @method static self Graduate()
 */
class ClassStanding extends Enum
{
    protected static function labels()
    {
        return [
            'Freshman' => 'Freshman',
            'Sophomore' => 'Sophomore',
            'Junior' => 'Junior',
            'Senior' => 'Senior',
            'SuperSenior' => 'Super Senior',
            'Graduate' => 'Graduate',
        ];
    }
}
