<?php

namespace Tests\Feature;

use App\src\Domain\Model\Card;
use App\src\Domain\Model\Number;
use App\src\Domain\Service\BingoCaller;
use App\src\Domain\Service\CardGenerator;
use Tests\TestCase;

class BingoTest extends TestCase
{
  
  /** @test */
  public function isAWinnerCard(): void
  {
    //todo -> improve test. It is quite unreliable.
    $cardGenerator = new CardGenerator();
    $card = $cardGenerator->makeCard();
    
    $caller = new BingoCaller();
    for ($i = Number::MIN; $i <= Number::MAX; $i++) {
      $calledNumber = $caller->call();
      $card->checkNumber($calledNumber);
      if ($card->totalMatchingNumbers() === Card::TOTAL_NUMBERS_IN_CARD) {
        break;
      }
    }
    $this->assertTrue($card->isBingo());
    $this->assertSame(Card::TOTAL_NUMBERS_IN_CARD, $card->totalMatchingNumbers());
  }
  
  /** @test */
  public function aMatchingNumberCannotBeRepeated(): void
  {
    $this->markTestSkipped('todo important');
    //todo
  }
}