<?php $m = $measure; $g = $groups; ?>
<form action="/measure/update" method="post">
    <input type="hidden" name="measure_id" value="<?= $m["id"] ?>">

    <input type="text" name="name" value="<?= $m["name"] ?>">

    <select name="group_id">
        <option value="" <?= ($m["group"] == "" ? " selected" : "") ?>></option>
        <?php foreach ($g as $id => $group): ?>
            <option value="<?= $id ?>"<?= ($m["group"] == $id ? " selected" : "") ?>><?= $group ?></option>
        <?php endforeach; ?>
    </select>

    <input type="submit">
</form>