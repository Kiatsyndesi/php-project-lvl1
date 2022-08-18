<?php

namespace BrainGames\Games\Calc;

require_once __DIR__ . '/../../vendor/autoload.php';

use BrainGames\Engine;

function playCalcGame()
{
    $name = Engine\universalGreeting('calc');

    $questions = Engine\randomizeQuestions('calc');

    Engine\gameLoop($questions, $name, 'calc');
}
