
<form method="post" action="/muscle/update">
<input type="hidden" name="muscle_id" value="<?= $id ?>">
<input type="text" name="name" value="<?= $name ?>">
<input type="checkbox" name="enabled" value="1" <?= $enabled ? ' checked' : '' ?>>
<input type="submit">
</form>