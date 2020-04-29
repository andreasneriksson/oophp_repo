<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?><h1>Guess my number</h1>
<main>
<p>Make a guess between 1-100 for my number.</p>
<form method="post">
    <input type="text" name="guess">
    <input type="submit" name="doGuess" value="Make a Guess">
    <input type="submit" name="doInit" value="Reset">
    <input type="submit" name="doCheat" value="Cheat">
</form>

<?php if ($res) : ?>
    <p><b><?= $res ?></b></p>
<?php endif; ?>
<?php if ($cheat) : ?>
    <p>Cheat: current number is <?= $cheat ?></p>
<?php endif; ?>


</main>


