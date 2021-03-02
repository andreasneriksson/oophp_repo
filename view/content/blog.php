<?php

namespace Anax\View;

if (!$res) {
    return;
}
$textfilter = new \Aner\MyTextFilter\MyTextFilter();

?>
 
<?php foreach ($res as $row) : ?>
<section>
    <header>
        <h2><a href="<?= url('content/blogPost/' . $textfilter->esc($row->slug)) ?>"><?= $textfilter->esc($row->title) ?></a></h2>
        <p><i>Published: <time datetime="<?= $textfilter->esc($row->published_iso8601) ?>" pubdate><?= $textfilter->esc($row->published) ?></time></i></p>
    </header>
    <?= $textfilter->esc($row->data) ?>
</section>
<?php endforeach; ?>