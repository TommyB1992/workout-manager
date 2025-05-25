document.getElementById('workout-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const start = this.start_date.value;
    const micro = this.microcycle.value;

    if (start && micro) {
        window.location.href = `/workout/${start}/${micro}`;
    }
});