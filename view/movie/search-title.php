<?php

namespace Anax\View;

?>

<form method="post" action="searchTitle">
    <fieldset>
    <legend>Sök</legend>
    <input type="hidden" name="route" value="searchtitle">
    <p>
        <label>Titel (använd % som wildcard):</label>
        <input type="search" name="search" value="<?= $search ?>"/>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Sök">
        <a href="<?= url("movie/show") ?>">Visa alla</a>
    </p>
    </fieldset>
</form>