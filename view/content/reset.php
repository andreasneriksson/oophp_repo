<?php

namespace Anax\View;

?>

<form class="content-cms" method="post" action="reset">
    <fieldset>
        <legend>Sök</legend>
        <input type="submit" name="reset" value="Reset database">
    </fieldset>
</form>

<?php
if (isset($_POST["reset"]) || isset($_GET["reset"])) {
    echo $reset;
}
