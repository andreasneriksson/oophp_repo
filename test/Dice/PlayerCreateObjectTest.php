<?php

namespace Aner\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player.
 */
class PlayerCreateObjectTest extends TestCase
{
    /**
     * Construct object, add a player outside of construct, get name of it.
     */
    public function testCreateObjectResetHand()
    {
        $player = new Player("testPlayer");
        $this->assertInstanceOf("\Aner\Dice\Player", $player);

        $player->addToHand(5);
        $player->addToHand(5);
        $player->addHandToTotal(5);
        $player->resetHand();
        $res = $player->getHandValue();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }

    public function testCreateObjectAddToHand()
    {
        $player = new Player("testPlayer");
        $this->assertInstanceOf("\Aner\Dice\Player", $player);

        $player->addToHand(5);
        $player->addToHand(5);
        $res = $player->getHandValue();
        $exp = 10;
        $this->assertEquals($exp, $res);
        $player->addHandToTotal();
        $res = $player->getTotal();
        $this->assertEquals($exp, $res);
    }

    public function testCreateObjectgetPlayer()
    {
        $player = new Player("testPlayer");
        $this->assertInstanceOf("\Aner\Dice\Player", $player);

        $res = $player->getPlayer();
        $exp = "testPlayer";
        $this->assertEquals($exp, $res);
    }
}
