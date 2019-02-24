<?php

namespace App\src\Domain\Model\Exception;

use App\src\Domain\Model\Column;
use Exception;

class CardException extends Exception
{
  public static function invalidColumn($givenElement): self
  {
    return new self(sprintf('%s object expected. %s given ', Column::class, $givenElement));
  }
  
  public static function invalidNumOfElements(int $validSize, int $currentSize): self
  {
    return new self(sprintf('The BingoCard has %s elements. Must have %s', $currentSize, $validSize));
  }
  
  public static function invalidNumOfCols(int $validSize, int $currentSize): self
  {
    return new self(sprintf('The BingoCard has %s columns. Must have %s', $currentSize, $validSize));
  }
}