<?php

namespace Anax\View;

?>

<form method="post">
    <fieldset>
    <legend>Välj film</legend>

    <p>
        <label>Film:<br>
        <select name="movieId">
            <option value="" hidden disbled>Välj film...</option>
            <?php foreach ($res as $movie) : ?>
            <option value="<?= $movie->id ?>"><?= $movie->title ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    </p>

    <p>
        <input type="submit" name="doAdd" value="Addera">
        <input type="submit" name="doEdit" value="Editera">
        <input type="submit" name="doDelete" value="Radera">
    </p>
    <p><a href="<?= url("movie/show") ?>">Visa alla</a></p>
    </fieldset>
</form>
