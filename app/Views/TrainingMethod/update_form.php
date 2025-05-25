
<form method="post" action="/training-method/update">
<input type="hidden" name="training_method_id" value="<?= $trainingMethod['id'] ?>">
<input type="text" name="name" value="<?= $trainingMethod['name'] ?>">
<textarea name="desc"><?= $trainingMethod['description'] ?></textarea>
<select name="js_file">
    <option value="">-</option>
    <?php foreach ($js_files as $file): ?>
        <option value="<?= $file ?>" <?= $trainingMethod['js_file'] == $file ? ' selected' : '' ?>><?= $file ?></option>
    <?php endforeach; ?>
</select>
<input type="submit">
</form>