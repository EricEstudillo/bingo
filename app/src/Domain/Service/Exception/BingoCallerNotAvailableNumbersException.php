<?php

namespace App\src\Domain\Service\Exception;

use App\src\Domain\Model\Number;
use Exception;

class BingoCallerNotAvailableNumbersException extends Exception
{
  public static function create()
  {
    return new self(
      sprintf('There are not available numbers to call between %s and %s', Number::MIN, Number::MAX)
    );
  }
}