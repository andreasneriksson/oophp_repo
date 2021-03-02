<?php

namespace Anax\View;

?>

<form method="post" action="searchYear">
    <fieldset>
    <legend>Sök</legend>
    <input type="hidden" name="route" value="searchyear">
    <p>
        <label>Skapade mellan: 
        <input type="number" name="year1" value="<?= $year1?>" min="1900" max="2100"/>
        - 
        <input type="number" name="year2" value="<?= $year2?>" min="1900" max="2100"/>
        </label>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Search">
        <a href="<?= url("movie/show") ?>">Visa alla</a>
    </p>
    </fieldset>
</form>