<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TestQuizType extends Enum
{
    const MULTIPLE_CHOICE = 0;
    const WRITING = 1;
}
