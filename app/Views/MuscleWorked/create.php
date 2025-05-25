<form method="post" action="/muscle-worked/create">
    <select name="muscle_id">
        <?php foreach ($muscles as $id => $m): ?> 
            <option value="<?= $id ?>"><?= $m["name"] ?></option>
        <?php endforeach; ?>
    </select>

    <select name="exercise_id">
        <?php foreach ($exercises as $id => $m): ?> 
            <option value="<?= $id ?>"><?= $m ?></option>
        <?php endforeach; ?>
    </select>

    <select name="involvement">
        <option value="1">1 (Primary)</option>
        <option value="1/2">1/2 (Secondary)</option>
        <option value="1/3">1/3 (Ternary)</option>
        <option value="1/4">1/4 (Accessory)</option>
    </select>
    <input type="submit">
</form>