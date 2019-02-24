<?php

namespace Tests\src\Domain\Service;

use App\src\Domain\Model\Card;
use App\src\Domain\Service\CardGenerator;
use Tests\TestCase;

class CardGeneratorTest extends TestCase
{
 /** @test */
 public function generateValidCard():void
 {
   //TODO -> Improve test. Unreliable.
     $sut = new CardGenerator();
     $card = $sut->makeCard();
     $this->assertInstanceOf(Card::class,$card);
 }
}
