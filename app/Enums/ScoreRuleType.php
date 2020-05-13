<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ScoreRuleType extends Enum
{
    // Score for each quiz, or score for a number of quizzes (like in Toeic)
    const EACH = 0;
    const COUNT = 1;
}
