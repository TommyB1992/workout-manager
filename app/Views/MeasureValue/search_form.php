<form id="measure-value-form">
    Misura:<br>
    <?php foreach ($measures as $id => $measure): ?>
        <input type="checkbox" id="measure_<?= $id ?>" name="show_by_measure" value="<?= $id ?>">
        <label for="measure_<?= $id ?>"><?= $measure['name'] ?></label><br>
    <?php endforeach; ?>

    <br>
    Exact date: <input type="date" name="show_by_date"><br>
    Start date: <input type="date" name="start_date"><br>
    End date: <input type="date" name="end_date"><br>

    <br>
    By:
    <select name="by">
        <option value="day" selected>Day</option>
        <option value="week">Week</option>
        <option value="month">Month</option>
        <option value="year">Year</option>
    </select>

    <br><br>
    <input type="submit" value="Invia">
</form>

<div id="measure-value-results">
    <table border=1>
                <tr>
                    <td>Data</td>
                    <td>Misura</td>
                    <td colspan="2">Valore</td>
                </tr>
    </table>
</div>

<script src="/js/measure-value.js" defer></script>