<h2>Report</h2>
<table border="1">
    <tr>
        <td>Muscolo</td>
        <td>Sets</td>
        <td>Reps</td>
        <td>Tonnellaggio</td>
    </tr>

    <?php foreach ($summary as $id => $data): ?>
        <tr>
            <td><?= htmlspecialchars($muscles[$id]) ?></td>
            <td><?= $data['sets'] ?></td>
            <td><?= $data['reps'] ?></td>
            <td><?= $data['weight'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>