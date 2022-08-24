<?php

namespace BrainGames\Games\Progression;

require_once __DIR__ . '/../../vendor/autoload.php';

use BrainGames\Engine;

function playProgressionGame()
{
    $name = Engine\universalGreeting('progression');

    $questions = Engine\randomizeQuestions('progression');

    Engine\gameLoop($questions, $name, 'progression');
}
