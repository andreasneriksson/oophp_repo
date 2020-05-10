<?php

namespace Aner\Dice;

//include(__DIR__ . "/Player.php");

/**
 * Player to 100 DiceGame
 */
class Game
{
    /**
     * @var string $player  Player name.
     * @var array $hand     Array of dice values at hand.
     * @var int $total      Total points in game.
     */
    public $players;
    public $currentPlayer;

    /**
     *
     */

    public function __construct()
    {
        $this->players = [];
        $this->addPlayer("Du");
        $this->addPlayer("Datorn");
        $this->currentPlayer = 0;
    }

    /**
     * Add player to game.
     *
     * @return void.
     */
    
    public function addPlayer($name)
    {
        array_push($this->players, new Player($name));
    }

    public function getPlayerTotal($val)
    {
        return $this->players[$val]->getTotal();
    }

    public function getName($val)
    {
        return $this->players[$val]->getPlayer();
    }

    public function nextPlayer()
    {
        $playerAmount = count($this->players) - 1;
        if ($playerAmount == $this->currentPlayer) {
            $this->currentPlayer = 0;
        } else {
            $this->currentPlayer += 1;
        }
        return $this->currentPlayer;
    }

    public function throwDice()
    {
        $curr = $this->currentPlayer;
        if ($this->getName($curr) == "Datorn") {
            return $this->pcPlayer();
        } else {
            $dice = rand(1, 6);
            if ($dice == 1) {
                $this->players[$curr]->resetHand();
                $this->nextPlayer();
                return "Du fick en {$dice}:a och förlorade din hand.";
            }
            $this->players[$curr]->addToHand($dice);
            return "Du fick en {$dice}:a.";
        }
    }

    public function addHand()
    {
        $curr = $this->currentPlayer;
        $hand = $this->players[$curr]->getHandValue();
        $this->players[$curr]->addHandToTotal();
        $this->players[$curr]->resetHand();
        $name = $this->getName($curr);
        if ($this->players[$curr]->getTotal() > 100) {
            return "{$name} är vinnaren!";
        }
        $this->nextPlayer();
        return "{$name} adderar {$hand} till din total";
    }

    public function pcPlayer()
    {
        $curr = $this->currentPlayer;
        while ($this->players[$curr]->getHandValue() < 15) {
            $dice = rand(1, 6);
            if ($dice == 1) {
                $this->players[$curr]->resetHand();
                $this->nextPlayer();
                return "Datorn fick en {$dice}:a och förlorade sin hand.";
            }
            $this->players[$curr]->addToHand($dice);
        }
        $hand = $this->players[$curr]->getHandValue();
        $this->players[$curr]->addHandToTotal();
        $this->players[$curr]->resetHand();
        $name = $this->getName($curr);
        if ($this->players[$curr]->getTotal() > 100) {
            return "{$name} är vinnaren!";
        }
        $this->nextPlayer();
        return "Datorn adderar {$hand} till sin total";
    }
}
