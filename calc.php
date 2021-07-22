<?php
/**
 * @param $left
 * @param $operator
 * @param $right
 * @return float|int|mixed
 * @throws Exception
 */
function calc($left, $operator, $right) {
    if (!is_numeric($left)) {
        throw new Exception("Left of the operator should be a number");
    }
    if (!is_numeric($right)) {
        throw new Exception("Right of the operator should be a number");
    }

    switch ($operator) {
        case "+":
            return $left + $right;
        case "-":
            return $left - $right;
        case "*":
            return $left * $right;
        case "/":
            if ($right == 0) {
                throw new Exception("Cannot divide by zero");
            }
            return $left / $right;
        case "%":
            return $left % $right;
        case "**":
            return $left ** $right;
        default:
            throw new Exception("Operator not valid");
    }

//    /**
//     * eval exposes a large security holes
//     * Rewrite this function so all of the tests pass
//     */
//    return eval("return $left$operator$right;");
}

if ($argc > 1 ) {
    $scriptName = $argv[0];
    $left = $argv[1];
    $operator = $argv[2];
    $right = $argv[3];
    echo "Evaluating: $left$operator$right\n";
    echo "Result: " . calc($left, $operator, $right);
}