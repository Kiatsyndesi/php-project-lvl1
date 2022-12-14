<?php

namespace BrainGames\Engine;

use function cli\line;
use function cli\prompt;

//Функция для нахождения наибольшего общего делителя
function findGcd(int $firstNumber, int $secondNumber): int
{
    /*return $secondNumber ? findGcd($secondNumber, $firstNumber % $secondNumber) : $firstNumber;*/
    if ($secondNumber === 0) {
        return $firstNumber;
    }

    return findGcd($secondNumber, $firstNumber % $secondNumber);
}

//Функция для нахождения пропущенного элемента в арифметической прогрессии
function findMissingNumber(array $progression): int
{
    $missingNumber = 0;
    $lastIndex = count($progression) - 1;

    for ($i = 0; $i <= $lastIndex; $i++) {
        if ($progression[$i] === '..') {
            if ($i === 0) {
                $step = $progression[$i + 2] - $progression[$i + 1];

                $missingNumber = $progression[$i + 1] - $step;
            } elseif ($i === $lastIndex) {
                $step = $progression[$i - 1] - $progression[$i - 2];

                $missingNumber = $progression[$i - 1] + $step;
            } else {
                $step = ($progression[$i + 1] - $progression[$i - 1]) / 2;

                $missingNumber = $progression[$i - 1] + $step;
            }
        }
    }

    return $missingNumber;
}

//Создание арифметической прогрессии с одним пропущенным элементом
function makeRandomRange(): string
{
    $startNumberForRange = rand(1, 10);
    $finishNumberForRange = rand(150, 160);
    $step = rand(10, 30);

    $progression = range($startNumberForRange, $finishNumberForRange, $step);
    $progression[array_rand($progression)] = '..';

    $progression = implode(' ', $progression);

    return "{$progression}";
}

//создаем рандомное выражение для вопросов игре-калькуляторе
function makeRandomExpression(): string
{
    $firstOperand = rand(0, 100);
    $secondOperand = rand(0, 100);

    $operations = ['+', '-', '*'];
    $randOperation = $operations[rand(0, 2)];

    return "{$firstOperand} {$randOperation} {$secondOperand}";
}

//функция для выполнения операции с выражением
function makeCalculation(string $optionFromQuestion): int
{
    $optionFromQuestion = explode(" ", $optionFromQuestion);

    $firstOperand = intval($optionFromQuestion[0]);
    $operation = $optionFromQuestion[1];
    $secondOperand = intval($optionFromQuestion[2]);

    $correctAnswer = 0;

    switch ($operation) {
        case '-':
            $correctAnswer = $firstOperand - $secondOperand;
            break;
        case '*':
            $correctAnswer = $firstOperand * $secondOperand;
            break;
        case '+':
            $correctAnswer = $firstOperand + $secondOperand;
            break;
    }
    return $correctAnswer;
}

//функция для проверки простое число или нет
function isPrime(int $number): string
{
    if ($number <= 1) {
        return 'no';
    }

    for ($i = 2, $division = $number / 2; $i <= $division; $i++) {
        if ($number % $i == 0) {
            return 'no';
        }
    }
    return 'yes';
}

//Универсальное приветствие с возвратом имени для последующего использования
function universalGreeting(string $typeOfGame): string
{
    line('Welcome to the Brain Games!');
    $name = prompt('May I have your name?');
    line("Hello, %s", $name);

    //Предложение сыграть разное для разных игр, каждому типу полагается свое
    switch ($typeOfGame) {
        case 'even':
            line("Answer \"yes\" if the number is even, otherwise answer \"no\".");
            break;
        case 'calc':
            line("What is the result of the expression?");
            break;
        case 'gcd':
            line("Find the greatest common divisor of given numbers.");
            break;
        case 'progression':
            line("What number is missing in the progression?");
            break;
        case 'prime':
            line("Answer \"yes\" if given number is prime. Otherwise answer \"no\".");
            break;
    }

    return $name;
}

//Рандомайзер для вопросов к играм
function randomizeQuestions(string $typeOfGame)
{
    switch ($typeOfGame) {
        //Рандомные вопросы для игры на четность и простые числа
        case 'prime':
        case 'even':
            return array_map(function () {
                return rand(0, 100);
            }, array_fill(0, 3, null));
        //Рандомные вопросы для калькулятора
        case 'calc':
            return array_map(function () {
                return makeRandomExpression();
            }, array_fill(0, 3, null));
        //Рандомные вопросы для нахождения НОД
        case 'gcd':
            return array_map(function () {
                $firstNumber = rand(1, 100);
                $secondNumber = rand(1, 100);

                return "{$firstNumber} {$secondNumber}";
            }, array_fill(0, 3, null));
        //Рандомная арифметическая прогрессия
        case 'progression':
            return array_map(function () {
                return makeRandomRange();
            }, array_fill(0, 3, null));
    }
}

//Универсальный обработчик ответа от пользователя
function userAnswerHandler(string $answer, string $typeOfGame)
{
    switch ($typeOfGame) {
        //обработчик для игры на четность и игры на простые числа
        case 'prime':
        case 'even':
            if ($answer === 'yes') {
                return 'yes';
            } elseif ($answer === 'no') {
                return 'no';
            } else {
                return null;
            }
        //Обработчик для калькулятора, НОД
        case 'gcd':
        case 'progression':
        case 'calc':
            $finalAnswer = intval($answer);

            return $finalAnswer;
    }
}

//Обработчик правильных ответов
function correctAnswerHandler(string $optionFromQuestion, string $typeOfGame)
{
    switch ($typeOfGame) {
        //обработчик для игры на четность
        case 'even':
            if ($optionFromQuestion % 2 === 0) {
                return 'yes';
            } else {
                return 'no';
            }
        //Обработчик для калькулятора
        case 'calc':
            return makeCalculation($optionFromQuestion);
        //Обработчик для нахождения НОД
        case 'gcd':
            $numbersForGcd = explode(" ", $optionFromQuestion);

            $correctGcd = findGcd(intval($numbersForGcd[0]), intval($numbersForGcd[1]));

            return $correctGcd;
        case 'progression':
            $optionFromQuestion = explode(" ", $optionFromQuestion);

            $missingNumber = findMissingNumber($optionFromQuestion);

            return $missingNumber;
        case 'prime':
            return isPrime(intval($optionFromQuestion));
    }
}

//Универсальный луп для ввода ответов и подсчета правильных ответов
function gameLoop(array $questions, string $name, string $typeOfGame)
{
    $countOfRightAnswers = 0;

    foreach ($questions as $question) {
        line("Question: {$question}");
        $userAnswer = prompt('Your answer');

        $correctAnswer = correctAnswerHandler($question, $typeOfGame);

        if (userAnswerHandler($userAnswer, $typeOfGame) === null) {
            line("'{$userAnswer}' is wrong answer ;(. Correct answer was '{$correctAnswer}'.");
            line("Let's try again, %s!", $name);
            return;
        }

        if (userAnswerHandler($userAnswer, $typeOfGame) === $correctAnswer) {
            line("Correct!");
            $countOfRightAnswers++;
        } else {
            line("'{$userAnswer}' is wrong answer ;(. Correct answer was '{$correctAnswer}'.");
            line("Let's try again, %s!", $name);
            return;
        }
    }

    if ($countOfRightAnswers === count($questions)) {
        line("Congratulations, %s!", $name);
    }
}
