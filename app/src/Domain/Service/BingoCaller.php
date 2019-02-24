<?php

namespace App\src\Domain\Service;

use App\src\Domain\Model\Number;
use App\src\Domain\Service\Exception\BingoCallerNotAvailableNumbersException;

class BingoCaller
{
  private $calledNumbers = [];
  private $availableNumbers = [];
  
  public function __construct()
  {
    //TODO-> Should availableNumbers be also Number::class ? Can we trust Number::MIN Number::MAX?
    for ($i = Number::MIN; $i <= Number::MAX; $i++) {
      $this->availableNumbers[] = $i;
    }
    \shuffle($this->availableNumbers);
  }
  
  public function call(): Number
  {
    
    $number = $this->nextAvailableNumber();
    $this->calledNumbers[(string)$number] = $number;
    
    return $number;
  }
  
  private function guardAgainstEmptyAvailableNumbers(): void
  {
    if (0 === count($this->availableNumbers)) {
      throw BingoCallerNotAvailableNumbersException::create();
    }
  }
  
  private function nextAvailableNumber(): Number
  {
    $this->guardAgainstEmptyAvailableNumbers();
    
    $pos = \count($this->availableNumbers) - 1;
    $number = new Number($this->availableNumbers[$pos]);
    unset($this->availableNumbers[$pos]);
    
    return $number;
  }
  
  public function totalCalledNumbers(): int
  {
    return \count($this->calledNumbers);
  }
}