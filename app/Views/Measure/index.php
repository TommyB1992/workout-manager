<table border="1">
    <tr>
        <td>#</td>
        <td>Misurazione</td>
        <td colspan="2">Tipo</td>
    </tr>

    <?php foreach ($measures as $id => $measure) { ?>
        <tr>
            <td><?= $id ?></td>
            <td><?= $measure["name"] ?></td>
            <td><?= $groups[$measure["group"]] ?></td>
            <td><a href="/measure/delete/<?= $id ?>">X</a> <a href="/measure/show/<?= $id ?>">E</a></td>
        </tr>
    <?php } ?>
</table>


<table border="1">
    <tr>
        <td>#</td>
        <td colspan="2">Gruppo</td>
    </tr>

    <?php foreach ($groups as $id => $group) { ?>
        <tr>
            <td><?= $id ?></td>
            <td><?= $group ?></td>
            <td><a href="/measure-group/delete/<?= $id ?>">X</a> <a href="/measure-group/show/<?= $id ?>">E</a></td>
        </tr>
    <?php } ?>
</table>

<br>
Crea misura:
<form action="/measure/create" method="post">
<input type="text" name="name" value="">
<select name="group_id">
        <option value=""></option>
        <?php foreach ($groups as $id => $name): ?>
            <option value="<?= $id ?>"><?= $name ?></option>
        <?php endforeach; ?>
</select>
<input type="submit">
</form>

<br>

Crea gruppo:
<form action="/measure-group/create" method="post">
<input type="text" name="name" value="">
<input type="submit">
</form>


<!--- todo: stampa tutte le misure sotto a un singolo gruyppo

    -->