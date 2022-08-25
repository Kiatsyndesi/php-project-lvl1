<?php

namespace BrainGames\Games\Prime;

require_once __DIR__ . '/../../vendor/autoload.php';

use BrainGames\Engine;

function playPrimeGame()
{
    $name = Engine\universalGreeting('prime');

    $questions = Engine\randomizeQuestions('prime');

    Engine\gameLoop($questions, $name, 'prime');
}
