<?php

namespace Aner\Dice;

/**
 * Player to 100 DiceGame
 */
class Player implements HistogramInterface
{

    use HistogramTrait;

    /**
     * @var string $player  Player name.
     * @var array $hand     Array of dice values at hand.
     * @var int $total      Total points in game.
     */
    private $player;
    private $hand;
    private $total;

    /**
     * Constructor to initiate the player,
     *
     * @param string $player The name of the player.
     */
    
    public function __construct($player)
    {
        $this->player = $player;
        $this->hand = [];
        $this->total = 0;
    }




    /**
     * Get the player name.
     *
     * @return string of playername set.
     */
    
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Get the player total.
     *
     * @return int of players total value.
     */
    
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Get total value of player hand.
     *
     * @return int of total value of hand.
     */
    
    public function getHandValue()
    {
        $totValue = 0;
        foreach ($this->hand as $value) {
            $totValue += $value;
        }
        return $totValue;
    }

    /**
     * Add value to hand.
     *
     * @return void.
     */
    
    public function addToHand($value)
    {
        array_push($this->hand, $value);
    }

    /**
     * Set hand as empty array.
     *
     * @return void.
     */
    
    public function resetHand()
    {
        $this->hand = [];
    }

    /**
     * Get hand array.
     *
     * @return void.
     */
    
    public function getHand()
    {
        return $this->hand;
    }

    /**
     * Set hand as empty array.
     *
     * @return void.
     */
    
    public function addHandToTotal()
    {
        foreach ($this->hand as $value) {
            $this->total += $value;
        }
        return $this->hand;
    }
}
