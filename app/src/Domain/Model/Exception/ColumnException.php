<?php

namespace App\src\Domain\Model\Exception;

use App\src\Domain\Model\Number;
use App\src\Domain\Model\Column;
use InvalidArgumentException;

class ColumnException extends InvalidArgumentException
{
  public static function invalidArgument($obj): self
  {
    return new self(\sprintf('Must be instance of %s. %s given.', Number::class, $obj));
  }
  
  public static function invalidSize(): self
  {
    return new self(sprintf('Must be %s elements per column.', Column::COLUMN_SIZE));
  }
  
  public static function elementAlreadyExist(Number $number): self
  {
    return new self(sprintf('Element %s already exist.', $number));
  }
}