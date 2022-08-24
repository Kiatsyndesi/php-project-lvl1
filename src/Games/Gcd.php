<?php

namespace BrainGames\Games\Gcd;

require_once __DIR__ . '/../../vendor/autoload.php';

use BrainGames\Engine;

function playGcdGame()
{
    $name = Engine\universalGreeting('gcd');

    $questions = Engine\randomizeQuestions('gcd');

    Engine\gameLoop($questions, $name, 'gcd');
}