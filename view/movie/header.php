<?php

namespace Anax\View;

?>

<navbar class="movie-navbar">
    <a href="<?= url("movie/show") ?>">Visa alla filmer</a> |
    <a href="<?= url("movie/title") ?>">Sök på titel</a> |
    <a href="<?= url("movie/year") ?>">Sök på år</a> |
    <a href="<?= url("movie/select") ?>">Modifiera</a> |
    <a href="<?= url("movie/reset") ?>">Återställ</a>
</navbar>