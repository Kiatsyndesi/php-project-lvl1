<?php

namespace BrainGames\Games\Even;

use function cli\line;
use function cli\prompt;

function isEven($number): bool
{
    if ($number % 2 !== 0) {
        return false;
    }

    return true;
}

function answerHandlerToBool($answer): bool
{
    switch ($answer) {
        case 'yes':
            return true;

        default:
            return false;
    }
}


function playEvenGame()
{
    line('Welcome to the Brain Games!');
    $name = prompt('May I have your name?');
    line("Hello, %s", $name);
    line("Answer \"yes\" if the number is even, otherwise answer \"no\".");

    $questions = [15, 6, 7];
    $countOfRightAnswers = 0;

    foreach ($questions as $question) {
        line("Question: {$question}");
        $userAnswer = prompt('Your answer');

        $correctAnswer = isEven($question) ? 'yes' : 'no';

        if ($userAnswer !== 'yes' && $userAnswer !== 'no') {
            line("{$userAnswer} is wrong answer ;(. Correct answer was {$correctAnswer}.");
            line("Let's try again, %s", $name);
            return;
        }

        if (answerHandlerToBool($userAnswer) === isEven($question)) {
            line("Correct!");
            $countOfRightAnswers++;
        } else {
            line("{$userAnswer} is wrong answer ;(. Correct answer was {$correctAnswer}.");
            line("Let's try again, %s", $name);
            return;
        }
    }

    if ($countOfRightAnswers === count($questions)) {
        line("Congratulations, %s", $name);
    }
}
