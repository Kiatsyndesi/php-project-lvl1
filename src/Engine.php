<?php

namespace BrainGames\Engine;

use function cli\line;
use function cli\prompt;

//Универсальное приветствие с возвратом имени для последующего использования
function universalGreeting(): string
{
    line('Welcome to the Brain Games!');
    $name = prompt('May I have your name?');
    line("Hello, %s", $name);
    line("Answer \"yes\" if the number is even, otherwise answer \"no\".");

    return $name;
}

//Универсальный обработчик ответа от пользователя
function userAnswerHandler($answer, $typeOfGame)
{
    switch ($typeOfGame) {
        case 'even':
            if ($answer === 'yes') {
                return 'yes';
            } elseif ($answer === 'no') {
                return 'no';
            } else {
                return null;
            }
    }
}

//Обработчик правильных
function correctAnswerHandler($optionFromQuestion, $typeOfGame)
{
    switch ($typeOfGame) {
        case 'even':
            if ($optionFromQuestion % 2 === 0) {
                return 'yes';
            } else {
                return 'no';
            }
    }
}

//Универсальный луп для ввода ответов и подсчета правильных ответов
function gameLoop($questions, $name, $typeOfGame)
{
    $countOfRightAnswers = 0;

    foreach ($questions as $question) {
        line("Question: {$question}");
        $userAnswer = prompt('Your answer');

        $correctAnswer = correctAnswerHandler($question, $typeOfGame);

        if (userAnswerHandler($userAnswer, $typeOfGame) === null) {
            line("{$userAnswer} is wrong answer ;(. Correct answer was {$correctAnswer}.");
            line("Let's try again, %s", $name);
            return;
        }

        if (userAnswerHandler($userAnswer, $typeOfGame) === $correctAnswer) {
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