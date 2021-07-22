<?php

require_once "calc.php";

function testCalc($left, $operator, $right, $correctAnswer) {
    echo "Evaluating: $left$operator$right-> ";
    try{
      $answer = calc($left, $operator, $right);
      if ($answer === $correctAnswer) {
          echo green("Passed") . " -> $answer === $correctAnswer\n";
      } else {
          echo red("Failed!") . " $answer !== $correctAnswer\n";
      }
    } catch (Exception $e) {
        echo red("Failed! ") . " - Caught exception: " . $e->getMessage() . "\n";
    }
}

/*
  I don't recommend custom error handlers in production code, at least for beginners
  but this facilitates my mini test framework
*/
/**
 * @param $errno
 * @param $errstr
 * @throws Exception
 */
function customError($errno, $errstr) {
    throw new Exception("Error triggered: [$errno] $errstr");
}
set_error_handler("customError");

/*
 * Handle Colors
 */

function red($str) {
    return "\033[41m$str\033[0m";
}

function green($str) {
    return "\033[42m$str\033[0m";
}


/*
 * TESTING happy path - test expecting to past
 */
$cleanTests = [
    ["10", "**", "2", 100],
    ["10", "%", "3", 1],
    ["2", "/", "2", 1],
    ["2", "*", "2", 4],
    ["1", "+", "1", 2],
    ["1", "-", "1", 0]
];

array_map(function($testData){
    testCalc($testData[0], $testData[1], $testData[2], $testData[3]);
}, $cleanTests);

/*
 * Test exception handling
 * Should catch a message that says cannot divide by 0
 */
try {
    echo "Divide by zero should throw exception -> ";
    $x = calc("1", "/", "0");
} catch(Exception $e) {
    $expectedMessage = 'Cannot divide by zero';
    if ($e->getMessage() == $expectedMessage) {
        echo green("Passed"). "\n";
    } else {
        echo red("Failed!") . " Exception message should be '$expectedMessage' - received: {$e->getMessage()}\n";
    }
}

/*
 * Test exception handling
 * Should catch an bad operator
 */
try {
    echo "Unsupported operators should throw exception -> ";
    $x = calc("1", ")", "0");
} catch(ParseError $e) {
    echo red("Failed!") . " - did you remove the eval() code?\n";
} catch(Exception $e) {
    $expectedMessage = 'Operator not valid';
    if ($e->getMessage() == $expectedMessage) {
        echo green("Passed"). "\n";
    } else {
        echo red("Failed!") . " Exception message should be '$expectedMessage' - received: {$e->getMessage()}\n";
    }
}

/*
 */

/*
 * Test exception handling
 * Test inputs are being validated
 */
try {
    echo "An exception should be throw if the LEFT side is not a number -> ";
    $x = calc("A", "/", "1");
} catch(Exception $e) {
    $expectedMessage = 'Left of the operator should be a number';
    if ($e->getMessage() == $expectedMessage) {
        echo green("Passed"). "\n";
    } else {
        echo red("Failed!") . " Exception message should be '$expectedMessage' - received: {$e->getMessage()}\n";
    }
}

try {
    echo "An exception should be throw if the RIGHT side is not a number -> ";
    $x = calc("1", "/", "A");
} catch (Error $e) {
    echo "Failed! Exception should be thrown with the message 'Right of the operator should be a number' - received: {$e->getMessage()}\n";
} catch(Exception $e) {
    $expectedMessage = 'Right of the operator should be a number';
    if ($e->getMessage() == $expectedMessage) {
        echo green("Passed"). "\n";
    } else {
        echo red("Failed!") . " Exception message should be '$expectedMessage' - received: {$e->getMessage()}\n";
    }
}
