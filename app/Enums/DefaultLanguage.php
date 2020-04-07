<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DefaultLanguage extends Enum
{
    const en = 'English';
    const vi = 'Tiếng Việt';
}
