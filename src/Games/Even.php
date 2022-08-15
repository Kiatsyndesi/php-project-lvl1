<?php

namespace BrainGames\Games\Even;

require_once __DIR__ . '/../../vendor/autoload.php';

use BrainGames\Engine;

function playEvenGame()
{
    $name = Engine\universalGreeting();

    $questions = [13, 4, 9, 10];

    Engine\gameLoop($questions, $name, 'even');
}
