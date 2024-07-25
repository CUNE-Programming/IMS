<?php

/*|=============================================================================|
  | Gender.php
  | Ian Kollipara <ian.kollipara@cune.edu>
  |-----------------------------------------------------------------------------|
  | This file contains the possible values for gender.
  |=============================================================================| */

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * The Gender Enumeration.
 * Although gender can be a variety of options,
 * we define an enumeration to simplify much of the devlopment.
 * In particular for fields that validate the number of boys and girls.
 *
 * @method static self Male()
 * @method static self Female()
 */
class Gender extends Enum
{
    //
}
