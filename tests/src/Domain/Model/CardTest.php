<?php

namespace Tests\src\Domain\Model;

use App\src\Domain\Model\Card;
use App\src\Domain\Model\Exception\CardException;
use App\src\Domain\Model\Column;
use Tests\TestCase;

class CardTest extends TestCase
{
  
  /** @test */
  public function incorrectNumberOfColumns(): void
  {
    $this->expectException(CardException::class);
    $columnStub = $this->createMock(Column::class);
    $matrix = [$columnStub, $columnStub, $columnStub, $columnStub];
    new Card($matrix);
  }
  
  /** @test */
  public function noColumns(): void
  {
    $this->expectException(CardException::class);
    $matrix = [0, 0, 0, 0, 0];
    new Card($matrix);
  }
  
  /** @test */
  public function incorrectNumberOfItems(): void
  {
    $this->expectException(CardException::class);
    $matrix = \array_map(function ($r) {
      $columnStub = $this->createMock(Column::class);
      $columnStub->method('totalCellsWithNumber')->willReturn($r);
      return $columnStub;
    }, [5, 5, 5, 5, 5]);
    new Card($matrix);
  }
  
  /** @test */
  public function buildAValidCard(): void
  {
    $matrix = \array_map(function ($r) {
      $columnStub = $this->createMock(Column::class);
      $columnStub->method('totalCellsWithNumber')->willReturn($r);
      return $columnStub;
    }, [5, 5, 4, 5, 5]);
    $sut = new Card($matrix);
    $this->assertInstanceOf(Card::class, $sut);
  }
}
