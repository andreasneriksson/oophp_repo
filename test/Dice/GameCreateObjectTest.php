<?php

namespace Aner\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceCreateObjectTest extends TestCase
{
    /**
     * Construct object, add a player outside of construct, get name of it.
     */
    public function testCreateObjectAddGetPlayer()
    {
        $game = new Game();
        $this->assertInstanceOf("\Aner\Dice\Game", $game);

        $game->addPlayer("test");
        $res = $game->getName(2);
        $exp = "test";
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object, get total points of player.
     */
    public function testCreateObjectGetTotal()
    {
        $game = new Game();
        $this->assertInstanceOf("\Aner\Dice\Game", $game);

        $res = $game->getPlayerTotal(0);
        $exp = 0;
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object, get total points of player.
     */
    public function testCreateObjectNextPlayer()
    {
        $game = new Game();
        $this->assertInstanceOf("\Aner\Dice\Game", $game);

        $res = $game->nextPlayer();
        $exp = 1;
        $this->assertEquals($exp, $res);
        $res = $game->nextPlayer();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object, Throw dice get return.
     */
    public function testCreateObjectThrowDice()
    {
        $game = new Game();
        $this->assertInstanceOf("\Aner\Dice\Game", $game);

        $res = $game->throwDice();

        $this->assertStringContainsString('Du fick en', $res);

        $game->nextPlayer();
        $res = $game->throwDice();
        $this->assertStringContainsString('Datorn', $res);
    }


    /**
     * Construct object, add hand.
     */
    public function testCreateObjectAddHand()
    {
        $game = new Game();
        $this->assertInstanceOf("\Aner\Dice\Game", $game);

        $testPlayer = $game->players[0];
        $testPlayer->addToHand(50);
        $res = $game->addHand();

        $this->assertStringContainsString('adderar 50 till din total', $res);

        $testPlayer = $game->players[1];
        $testPlayer->addToHand(110);
        $res = $game->addHand();

        $this->assertStringContainsString('är vinnaren', $res);
    }
}
