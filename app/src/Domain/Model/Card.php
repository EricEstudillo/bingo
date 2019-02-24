<?php

namespace App\src\Domain\Model;

use App\src\Domain\Model\Exception\CardException;

class Card
{
  public const CARD_SIZE = 5;
  public const TOTAL_NUMBERS_IN_CARD = 24;
  
  protected $matrix = [];
  
  public function __construct(array $matrix)
  {
    $this->guardAgainstInvalidNumOfColumns($matrix);
    
    $totalNumbersInCard = 0;
    /** @var Column $column */
    foreach ($matrix as $column) {
      $this->checkIsColumn($column);
      $totalNumbersInCard += $column->totalCellsWithNumber();
      $this->matrix[] = $column;
    }
    $this->checkNumOfCellsWithNumber($totalNumbersInCard);
  }
  
  public function checkNumber(Number $numberToCheck): bool
  {
    $isInColumn = false;
    /** @var Column $column */
    foreach ($this->matrix as $column) {
      $isInColumn = $column->checkNumber($numberToCheck);
      if ($isInColumn) {
        return $isInColumn;
      }
    }
    
    return $isInColumn;
  }
  
  public function isBingo(): bool
  {
    return self::TOTAL_NUMBERS_IN_CARD === $this->totalMatchingNumbers();
  }
  
  public function totalMatchingNumbers(): int
  {
    //todo -> Should it be private? Do we need to expose this behaviour?
    $matchingNumbersCounter = 0;
    /** @var Column $column */
    foreach ($this->matrix as $column) {
      $matchingNumbersCounter += $column->totalMatchingNumbers();
    }
    return $matchingNumbersCounter;
  }
  
  private function checkIsColumn($column): void
  {
    if (false === $column instanceof Column) {
      throw CardException::invalidColumn($column);
    }
  }
  
  private function checkNumOfCellsWithNumber($totalNumbersInCard): void
  {
    if (self::TOTAL_NUMBERS_IN_CARD !== $totalNumbersInCard) {
      throw CardException::invalidNumOfElements(self::TOTAL_NUMBERS_IN_CARD, $totalNumbersInCard);
    }
  }
  
  private function guardAgainstInvalidNumOfColumns(array $matrix): void
  {
    if (self::CARD_SIZE !== count($matrix)) {
      throw CardException::invalidNumOfCols(self::CARD_SIZE, count($matrix));
    }
  }
}