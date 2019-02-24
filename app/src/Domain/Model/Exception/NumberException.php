<?php

namespace App\src\Domain\Model\Exception;

use Exception;

class NumberException extends Exception
{
  public static function invalidArgument(int $givenNumber, int $min, int $max)
  {
    return new self(\sprintf('Invalid number %s. It must be between %s and %s', $givenNumber, $min, $max));
  }
}