<?php

namespace Tests\src\Domain\Model;

use App\src\Domain\Model\Number;
use App\src\Domain\Model\Column;
use App\src\Domain\Model\Exception\ColumnException;
use Tests\TestCase;

class ColumnTest extends TestCase
{
  
  /** @test */
  public function aColumnMustHaveADefinedNumOfElements(): void
  {
    $this->expectException(ColumnException::class);
    $attributes = \array_map(function ($i) {
      $bingoNumber = $this->createMock(Number::class);
      $bingoNumber->method('__toString')->willReturn($i);
      return $bingoNumber;
    }, [1, 2, 3, 4]);
    new Column($attributes);
  }
  
  /** @test */
  public function canOnlyInsertBingoNumbersOrNull(): void
  {
    $this->expectException(ColumnException::class);
    $attributes = \array_map(function ($i) {
      $bingoNumber = $this->createMock(Number::class);
      $bingoNumber->method('__toString')->willReturn($i);
      $bingoNumber->method('number')->willReturn($i);
      return $bingoNumber;
    }, [1, 2, 3, 4]);
    $attributes[] = 'invalidElement';
    new Column($attributes);
  }
  
  /** @test */
  public function canOnlyInsertUniqueElements(): void
  {
    $this->expectException(ColumnException::class);
    $attributes = \array_map(function ($i) {
      $bingoNumber = $this->createMock(Number::class);
      $bingoNumber
        ->expects($this->atLeast(1))
        ->method('__toString')
        ->willReturn($i);
      return $bingoNumber;
    }, [1, 2, 3, 4, 4]);
    new Column($attributes);
  }
  
  /** @test */
  public function calcCorrectSize(): void
  {
    $attributes = $this->createValidStubAttributes(4);
    $attributes[] = null;
    $sut = new Column($attributes);
    
    $this->assertSame(4, $sut->totalCellsWithNumber());
  }
  
  /** @test */
  public function aNumberIsInColumn(): void
  {
    $attributes = $this->createValidStubAttributes();
    
    $sut = new Column($attributes);
    
    $this->assertTrue($sut->checkNumber($attributes[0]));
    
    $nonExistentNumberStub = $this->createMock(Number::class);
    $nonExistentNumberStub->expects($this->atLeast(1))
      ->method('number')
      ->willReturn(70);
    $this->assertFalse($sut->checkNumber($nonExistentNumberStub));
  }
  
  private function createValidStubAttributes(int $numberOfElements = 5): array
  {
    $returnValues = [];
    for ($i = 1; $i <= $numberOfElements; $i++) {
      $returnValues[] = $i;
    }
    
    return \array_map(function ($i) {
      $bingoNumber = $this->createMock(Number::class);
      $bingoNumber->expects($this->atLeast(1))
        ->method('__toString')
        ->willReturn($i);
      $bingoNumber->method('number')
        ->willReturn($i);
      return $bingoNumber;
    }, $returnValues);
  }
}
