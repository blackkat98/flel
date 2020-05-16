<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class FocusOnAspect extends Enum
{
    const grammar = 0;
    const vocabulary = 1;
    const reading = 2;
    const listening = 3;
    const logic = 4;
}
