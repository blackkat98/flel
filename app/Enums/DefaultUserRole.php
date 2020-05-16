<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DefaultUserRole extends Enum
{
    const root = 0;
    const admin = 1;
    const editor = 2;
}
