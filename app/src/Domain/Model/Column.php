<?php

namespace App\src\Domain\Model;

use App\src\Domain\Model\Exception\ColumnException;

class Column
{
  public const COLUMN_SIZE = 5;
  
  private $column = [];
  private $numbersInColumn = [];
  private $matchingNumbersCounter = 0;
  
  public function __construct(array $cells)
  {
    $this->guardAgainstInvalidSize($cells);
    foreach ($cells as $number) {
      if (null === $number) {
        $this->column[] = null;
        continue;
      }
      
      $this->guardAgainstInvalidNumber($number);
      $key = (string)$number;
      if (\array_key_exists($key, $this->numbersInColumn)) {
        throw ColumnException::elementAlreadyExist($number);
      }
      
      $this->numbersInColumn[$key] = false;
      $this->column[] = $number;
    }
  }
  
  public function checkNumber(Number $numberToCheck): bool
  {
    $isInColumn = \array_key_exists($numberToCheck->number(), $this->numbersInColumn);
    if ($isInColumn && false === $this->numbersInColumn[(string)$numberToCheck]) {
      $this->markNumberAsCalled($numberToCheck);
    }
    return $isInColumn;
  }
  
  public function totalCellsWithNumber(): int
  {
    return count($this->numbersInColumn);
  }
  
  public function totalMatchingNumbers(): int
  {
    return $this->matchingNumbersCounter;
  }
  
  private function guardAgainstInvalidSize(array $cells): void
  {
    if (self::COLUMN_SIZE !== \count($cells)) {
      throw ColumnException::invalidSize();
    }
  }
  
  private function guardAgainstInvalidNumber($number): void
  {
    if (false === $number instanceof Number) {
      throw ColumnException::invalidArgument($number);
    }
  }
  
  private function markNumberAsCalled(Number $numberToCheck): void
  {
    $this->numbersInColumn[(string)$numberToCheck] = true;
    $this->matchingNumbersCounter++;
  }
}