<form id="workout-form">
    Start: <input type="date" name="start_date" value="<?= $start_date ?>">
    Microciclo: <input type="number" name="microcycle" min="1" max="14" value="<?= $microcycle ?>">
    <input type="submit" value="Visualizza">
</form>

<!--
TODO: salvare l'ultima data e l'ultimo microciclo nel session storage
-->

<script src="/js/date-form.js" defer></script>