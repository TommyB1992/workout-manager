document.addEventListener('DOMContentLoaded', function () {
    const exactDateInput = document.querySelector('input[name="show_by_date"]');
    const startDateInput = document.querySelector('input[name="start_date"]');
    const endDateInput = document.querySelector('input[name="end_date"]');

    exactDateInput.addEventListener('input', () => {
        if (exactDateInput.value) {
            startDateInput.value = '';
            endDateInput.value = '';
        }
    });

    function clearExactDateIfSet() {
        if (startDateInput.value || endDateInput.value) {
            exactDateInput.value = '';
        }
    }

    startDateInput.addEventListener('input', clearExactDateIfSet);
    endDateInput.addEventListener('input', clearExactDateIfSet);

    document.getElementById('measure-value-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        const data = {};
        for (const [key, value] of formData.entries()) {
            if (key in data) {
                if (Array.isArray(data[key])) {
                    data[key].push(value);
                } else {
                    data[key] = [data[key], value];
                }
            } else {
                data[key] = value;
            }
        }

        fetch('/measure-value/search', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            const div = document.getElementById('measure-value-results');
            div.innerHTML = `
                <table border=1>
                    <tr>
                        <td>Data</td>
                        <td>Misura</td>
                        <td colspan="2">Valore</td>
                    </tr>
                </table>
            `;
        })
        .catch(error => {
            console.error("Errore:", error);
        });
    });
});
