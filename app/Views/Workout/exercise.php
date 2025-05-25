<?php
use App\Helpers\HtmlHelper;
?>
<?php if ($reps): ?>
<table border="1">
    <tr>
        <td>Reps</td>
        <td colspan="2">Weight</td>
    </tr>
    <?php foreach ($reps as $wk): ?>
        <tr>
            <td><?= $wk["num"] ?></td>
            <td><?= $wk["weight"] ?></td>
            <td>E <a href="/workout-rep/delete/<?= $wk["id"] ?>">X</a></td>
        </tr>

        <?php if ($wk["rec_min"] > 0 || $wk["rec_sec"] > 0): ?>
            <tr>
                <td colspan="3" align="center">
                    <?= ($wk["rec_min"] > 0 ? $wk["rec_min"] . "'" : "") ?>
                    <?= ($wk["rec_sec"] > 0 ? $wk["rec_sec"] . "\"" : "") ?>
                </td>
            <tr>
        <?php endif ?>
    <?php endforeach; ?>
</table>
<?php endif; ?>

<hr>
<form method="post" action="/workout-rep/create">
    <input type="hidden" name="workout_id" value="<?= HtmlHelper::getSendedInput('workout', $id) ?>">
    Kg: <input type="text" name="weight" value="<?= HtmlHelper::getSendedInput('weight') ?>"><br>
    Reps: <input type="text" name="reps" value="<?= HtmlHelper::getSendedInput('reps') ?>"><br>
    Rec: <input type="text" name="rec_min" value="<?= HtmlHelper::getSendedInput('rec_min', 0) ?>">m <input type="text" name="rec_sec" value="<?= HtmlHelper::getSendedInput('rec_sec', 0) ?>">s<br>
    <input type="hidden" name="referer" value="/workout/show/<?= $id ?>">
    <input type="submit">
</form>