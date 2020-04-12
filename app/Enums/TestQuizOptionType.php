<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TestQuizOptionType extends Enum
{
    const TEXT = 0;
    const IMAGE = 1;
}
