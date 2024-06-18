<?php

/*|=============================================================================|
  | Gender.php
  | Ian Kollipara <ian.kollipara@cune.edu>
  |-----------------------------------------------------------------------------|
  | This file contains the possible values for gender.
  |=============================================================================| */

namespace App\Enums;

enum Gender: string
{
    case Male = 'male';
    case Female = 'female';
}
