<?php

namespace Tests\src\Domain\Model;

use App\src\Domain\Model\Number;
use App\src\Domain\Model\Exception\NumberException;
use Tests\TestCase;

class NumberTest extends TestCase
{
  
  /**
   * @test
   * @dataProvider validNumbersDataProvider
   * @param int $number
   */
  public function createValidNumber(int $number): void
  {
    $sut = new Number($number);
    $this->assertInstanceOf(Number::class, $sut);
    $isNotSmallerThanMin = $sut->number() >= Number::MIN;
    $isNotBiggerThanMax = $sut->number() <= Number::MAX;
    
    $this->assertSame($number, $sut->number());
    $this->assertTrue($isNotSmallerThanMin);
    $this->assertTrue($isNotBiggerThanMax);
  }
  
  public function validNumbersDataProvider()
  {
    return [
      '1' => [
        'number' => 1
      ],
      '75' => [
        'number' => 75
      ],
      '74' => [
        'number' => 74
      ],
      '2' => [
        'number' => 2
      ],
      '10' => [
        'number' => 10
      ],
      '59' => [
        'number' => 59
      ],
    ];
  }
  
  /**
   * @test
   * @dataProvider invalidNumbersDataProvider
   * @param int $number
   */
  public function invalidNumberThrowsException(int $number): void
  {
    $this->expectException(NumberException::class);
    new Number($number);
  }
  
  public function invalidNumbersDataProvider()
  {
    return [
      '0' => [
        'number' => 0
      ],
      '-1' => [
        'number' => -1
      ],
      '76' => [
        'number' => 76
      ],
      'PHP max' => [
        'number' => \PHP_INT_MAX
      ],
      'PHP min' => [
        'number' => \PHP_INT_MIN
      ],
    ];
  }
}
