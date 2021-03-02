<?php

namespace Anax\View;

if (!$res) {
    return;
}
?>

<table class="content-cms">
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Path</th>
        <th>Slug</th>
        <th>Published</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
        <th>Uppdatera / Redigera</th>
    </tr>
<?php foreach ($res as $row) : ?>
    <tr>
        <td><?= $row->id ?></td>
        <td><?= $row->title ?></td>
        <td><?= $row->type ?></td>
        <td><?= $row->path ?></td>
        <td><?= $row->slug ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
        <td class="table-right-align"><a href="<?= url("content/edit/" . $row->id) ?>"><i class="fas fa-edit"></i></a>
            <a href="<?= url("content/delete/" . $row->id) ?>"><i class="fas fa-trash"></i></a></td>
    </tr>
<?php endforeach; ?>
</table>