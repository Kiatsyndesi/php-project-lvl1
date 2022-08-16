<?php

namespace BrainGames\Games\Even;

require_once __DIR__ . '/../../vendor/autoload.php';

use BrainGames\Engine;

function playEvenGame()
{
    $name = Engine\universalGreeting();

    $questions = Engine\randomizeQuestions('even');

    Engine\gameLoop($questions, $name, 'even');
}
