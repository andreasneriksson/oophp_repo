<main>
    <p>Make a guess between 1-100 for my number.</p>
    <form method="post">
        <input type="text" name="guess">
        <input type="submit" name="doGuess" value="Make a Guess">
        <input type="submit" name="doInit" value="Reset">
        <input type="submit" name="doCheat" value="Cheat">
    </form>

<?php if ($game->tries() !== 0) : ?>
    <?php if ($doGuess) : ?>
        <p><b><?= $game->makeGuess($guess); ?></b></p>
    <?php endif; ?>
    <?php if ($doCheat) : ?>
        <p>Cheat: current number is <?= $game->number(); ?></p>
    <?php endif; ?>
<?php endif; ?>
<?php if ($game->tries() == 0) : ?>
    <p>Sorry, no guesses left. Reset tu start new game!</p>
<?php endif; ?>
</main>