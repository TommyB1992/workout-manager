<?php
use App\Helpers\HtmlHelper;
?>
<form method="post" action="/workout/create/<?= htmlspecialchars($date) ?>">
Esercizio: <select name="exercise_id">
<?php foreach ($exercises as $id => $exercise): ?>
    <option value="<?= $id ?>"><?= htmlspecialchars($exercise) ?></option>
<?php endforeach; ?>
</select>

<?php if (count($trainingMethods)): ?>
    <br>Metodologia: <select name="training_method_id">
    <option value=""></option>
    <?php foreach ($trainingMethods as $method): ?>
        <option value="<?= $method["id"] ?>" js-file="<?= $method["js_file"] ?>"><?= htmlspecialchars($method["name"]) ?></option>
    <?php endforeach; ?>
    </select>
<?php endif; ?>

<br>Descrizione (utilizzato per la stampa): <textarea name="desc"><?= HtmlHelper::getSendedInput('desc') ?></textarea>
<br>Per il giorno: <input type="text" name="date" value="<?= htmlspecialchars($date) ?>" disabled><br>

<?= HtmlHelper::getInputReferer('/workout') ?>
<input type="submit">
</form>

<!--

todo: caricare il javascript per emom e bill starr

    -->