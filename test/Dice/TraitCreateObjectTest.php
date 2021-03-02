<?php

namespace Aner\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player.
 */
class TraitCreateObjectTest extends TestCase
{
    /**
     * Construct object, add a player outside of construct, get name of it.
     */
    public function testCreateObjectPrintHistogram()
    {
        $game = new Game();
        $game->addPlayer("test");
        
        array_push($game->serie, 1);
        array_push($game->serie, 2);
        array_push($game->serie, 3);
        array_push($game->serie, 4);
        array_push($game->serie, 5);
        array_push($game->serie, 6);

        $str1 = "1: *";
        $str2 = "2: *";
        $str3 = "3: *";
        $str4 = "4: *";
        $str5 = "5: *";
        $str6 = "6: *";
        $arr = [$str1, $str2, $str3, $str4, $str5, $str6];
        $exp = "";

        foreach ($arr as &$val) {
            $exp .= $val;
            $exp .= "<br>";
        }

        $res = $game->PrintHistogram();

        $this->assertEquals($exp, $res);
    }
}
