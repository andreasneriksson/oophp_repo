<?php

namespace Anax\View;

?>

<form method="post" action="edit">
    <fieldset>
    <legend>Editera</legend>
    <input type="hidden" name="movieId" value="<?= $movie->id ?>"/>

    <p>
        <label>Titel:<br> 
        <input type="text" name="movieTitle" value="<?= $movie->title ?>"/>
        </label>
    </p>

    <p>
        <label>År:<br> 
        <input type="number" name="movieYear" value="<?= $movie->year ?>"/>
    </p>

    <p>
        <label>Bild:<br> 
        <input type="text" name="movieImage" value="<?= $movie->image ?>"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Spara">
        <input type="reset" name="doReset" value="Återställ">
    </p>
    <p>
        <a href="<?= url("movie/select") ?>">Välj film</a>
    </p>
    </fieldset>
</form>
