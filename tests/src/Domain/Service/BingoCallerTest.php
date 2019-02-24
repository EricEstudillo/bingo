<?php

namespace Tests\src\Domain\Service;

use App\src\Domain\Model\Number;
use App\src\Domain\Service\BingoCaller;
use App\src\Domain\Service\Exception\BingoCallerNotAvailableNumbersException;
use Tests\TestCase;

class BingoCallerTest extends TestCase
{
  const NUMBER_OF_CALLS = 75;
  
  /** @test */
  public function validNumberOfCalls(): void
  {
    $sut = new BingoCaller();
    for ($i = 0; $i < Number::MAX; $i++) {
      $this->assertInstanceOf(Number::class, $sut->call());
    }
    $this->assertSame(self::NUMBER_OF_CALLS, $sut->totalCalledNumbers());
  }
  
  /** @test */
  public function callsDoNotRepeatNumbers(): void
  {
    $sut = new BingoCaller();
    $calledNumbers = [];
    for ($i = 0; $i < Number::MAX; $i++) {
      $number = ($sut->call())->number();
      $calledNumbers [] = $number;
    }
    $this->assertSame(self::NUMBER_OF_CALLS, count(\array_unique($calledNumbers)));
  }
  
  /** @test */
  public function callAllCompulsoryNumbers(): void
  {
    $sut = new BingoCaller();
    
    $compulsoryNumbers = [];
    for ($i = Number::MIN; $i <= Number::MAX; $i++) {
      $compulsoryNumbers[(string)$i] = $i;
    }
    
    for ($i = 0; $i < Number::MAX; $i++) {
      $number = ($sut->call())->number();
      $key = (string)$number;
      if (\array_key_exists($key, $compulsoryNumbers)) {
        unset($compulsoryNumbers[$key]);
      }
    }
    $this->assertSame(0, count($compulsoryNumbers));
  }
  
  /** @test */
  public function fullCollectionThrowsException(): void
  {
    $this->expectException(BingoCallerNotAvailableNumbersException::class);
    
    $sut = new BingoCaller();
    $moreCallsThanExpected = Number::MAX + 1;
    for ($i = 0; $i < $moreCallsThanExpected; $i++) {
      $sut->call();
    }
  }
}
