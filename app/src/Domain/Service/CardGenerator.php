<?php

namespace App\src\Domain\Service;

use App\src\Domain\Model\Card;
use App\src\Domain\Model\Column;
use App\src\Domain\Model\Number;

class CardGenerator
{
  
  private const BOUND_INTERVAL = 15;
  
  public function makeCard(): Card
  {
    $matrix = [];
    $min = 1;
    for ($columnPos = 0; $columnPos < Card::CARD_SIZE; $columnPos++) {
      $intervalNumbers = $this->createIntervalNumbers($min);
      $min += self::BOUND_INTERVAL;
      $cells = [];
      for ($rowPos = 0; $rowPos < Card::CARD_SIZE; $rowPos++) {
        $isMiddleCell = $rowPos == 2 && $columnPos == 2;
        $cells[] = $isMiddleCell ? null : new Number($intervalNumbers[$rowPos]);
      }
      $matrix[] = new Column($cells);
    }
    
    return new Card($matrix);
  }
  
  private function createIntervalNumbers(int $min): array
  {
    $max = $min + self::BOUND_INTERVAL;
    $allowedNumbers = [];
    for ($i = $min; $i < $max; $i++) {
      $allowedNumbers[] = $i;
    }
    \shuffle($allowedNumbers);
    return $allowedNumbers;
  }
}