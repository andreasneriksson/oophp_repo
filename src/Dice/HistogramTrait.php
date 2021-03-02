<?php

namespace Aner\Dice;

/**
 * A trait implementing histogram for integers.
 */
trait HistogramTrait
{
    /**
     * @var array $serie  The numbers stored in sequence.
     */
    public $serie = [];



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getHistogramSerie()
    {
        return $this->serie;
    }



    /**
     * Print out the histogram, default is to print out only the numbers
     * in the serie, but when $min and $max is set then print also empty
     * values in the serie, within the range $min, $max.
     *
     * @return string representing the histogram.
     */
    public function printHistogram()
    {
        $returnString = "";

        $str1 = "1: ";
        $str2 = "2: ";
        $str3 = "3: ";
        $str4 = "4: ";
        $str5 = "5: ";
        $str6 = "6: ";
        foreach ($this->serie as &$value) {
            if ($value === 1) {
                $str1 .= "*";
            }
            if ($value === 2) {
                $str2 .= "*";
            }
            if ($value === 3) {
                $str3 .= "*";
            }
            if ($value === 4) {
                $str4 .= "*";
            }
            if ($value === 5) {
                $str5 .= "*";
            }
            if ($value === 6) {
                $str6 .= "*";
            }
        }
        $arr = [$str1, $str2, $str3, $str4, $str5, $str6];
        foreach ($arr as &$val) {
            $returnString .= $val;
            $returnString .= "<br>";
        }
        return $returnString;
    }
}
