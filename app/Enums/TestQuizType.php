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
    const multiple_choice = 0;
    const writing = 1;
}
