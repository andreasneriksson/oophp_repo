<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?><h1>Dice Game</h1>
<main>
    <p>Klicka på spela för att kasta tärningen och stanna för att stanna och 
    addera poängen till totalen. Slå en 1:a och du förlorar din hand.</p>
    <h3>Poängtavla:</h3>
    <p><?= $game->getName(0); ?>: <?= $game->getPlayerTotal(0); ?></p>
    <p><?= $game->getName(1); ?>: <?= $game->getPlayerTotal(1); ?></p>
    <form method="post">
        <input type="submit" name="doThrow" value="Spela">
        <input type="submit" name="doStop" value="Stanna">
    </form>

<?php if ($throw) : ?>
    <p><?= $throw ?></p>
<?php endif; ?>
<?php if ($stop) : ?>
    <p><?= $stop ?></p>
<?php endif; ?>


</main>