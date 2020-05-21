<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class WordType extends Enum
{
    const noun = 0;
    const verb = 1;
    const adjective = 2;
    const adverb = 3;
    const preposition = 4;
    const pronoun = 5;
    const object_ = 6;
}
