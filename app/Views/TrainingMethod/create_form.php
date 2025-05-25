
<form method="post" action="/training-method/create">
<input type="text" name="name">
<textarea name="desc"></textarea>
<select name="js_file">
    <option value="">-</option>
    <?php foreach ($js_files as $file): ?>
        <option value="<?= $file ?>"><?= $file ?></option>
    <?php endforeach; ?>
</select>
<input type="submit">
</form>