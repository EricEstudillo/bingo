<?php

namespace App\src\Domain\Model;

use App\src\Domain\Model\Exception\NumberException;

class Number
{
  public const MIN = 1;
  public const MAX = 75;
  
  private $number;
  
  public function __construct(int $number)
  {
    $this->guardAgainstInvalidNumber($number);
    $this->number = $number;
  }
  
  public function number(): int
  {
    return $this->number;
  }
  
  private function guardAgainstInvalidNumber(int $number): void
  {
    if ($number < self::MIN || $number > self::MAX) {
      throw NumberException::invalidArgument($number, self::MIN, self::MAX);
    }
  }
  
  public function __toString(): string
  {
    return (string)$this->number();
  }
}