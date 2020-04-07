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
    const ROOT = 0;
    const ADMIN = 1;
    const EDITOR = 2;
    const NORMAL = 3;
}
