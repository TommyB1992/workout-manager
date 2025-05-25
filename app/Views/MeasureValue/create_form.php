<form action="/measure-value/create" method="post">
<input type="text" name="value">
    
<input type="date" name="date">

    <select name="measure_id">
        <?php foreach ($measures as $id => $measure): ?>
            <option value="<?= $id ?>"><?= $measure['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <input type="submit" value="Invia">
</form>
