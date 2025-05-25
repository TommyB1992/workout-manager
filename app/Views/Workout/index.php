<a href="/workout/<?= $prev ?>/<?= $microcycle ?>">Prev</a> | 
<a href="/workout/<?= $next ?>/<?= $microcycle ?>">Next</a>

<hr>

<?php foreach ($workoutDays as $day => $workouts): ?>
    <div>
        <?= $day ?> (<a href="/workout/create/<?= $day ?>">+</a>)
        <?php foreach ($workouts as $workout): ?>
            <div>
                <span><?= $workout["e_name"] ?></span>
                <span><?= $workout["t_name"] ?></span>
                <span><a href="/workout/show/<?= $workout["w_id"] ?>">🖉</a> <a href="/workout/delete/<?= $workout["w_id"] ?>">✖</a></span>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>