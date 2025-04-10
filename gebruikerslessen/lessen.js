document.addEventListener("DOMContentLoaded", function () {
    const priceInput = document.getElementById("Filter-1");
    const dateInput = document.getElementById("Filter-3");
    const sortSelect = document.getElementById("Filter-2");
    const tableBody = document.querySelector("#table-leden tbody");

    function filterTable() {
        const maxPrice = parseFloat(priceInput.value) || Infinity;
        const selectedDate = dateInput.value;
        const rows = Array.from(tableBody.querySelectorAll("tr"));

        let visibleCount = 0;

        rows.forEach(row => {
            const cells = row.getElementsByTagName("td");

            // Verwijder vorige "geen lessen" rij
            if (row.classList.contains("no-results")) {
                row.remove();
                return;
            }

            const price = parseFloat(cells[5].innerText.replace(',', '.')) || 0;
            const date = cells[1].innerText.trim();

            const priceMatch = price <= maxPrice;
            const dateMatch = !selectedDate || date === selectedDate;

            if (priceMatch && dateMatch) {
                row.style.display = "";
                visibleCount++;
            } else {
                row.style.display = "none";
            }
        });

        if (visibleCount === 0) {
            const noResultRow = document.createElement("tr");
            noResultRow.classList.add("no-results");
            noResultRow.innerHTML = `
                <td colspan="7" class="text-center fw-bold text-danger">Geen lessen gevonden.</td>
            `;
            tableBody.appendChild(noResultRow);
        }

        sortTable(); // Sorteer enkel zichtbare lessen
    }

    function sortTable() {
        const ascending = sortSelect.value === "0";
        const rows = Array.from(tableBody.querySelectorAll("tr"))
            .filter(row => row.style.display !== "none" && !row.classList.contains("no-results"));

        rows.sort((a, b) => {
            const priceA = parseFloat(a.cells[5].innerText.replace(',', '.')) || 0;
            const priceB = parseFloat(b.cells[5].innerText.replace(',', '.')) || 0;
            return ascending ? priceA - priceB : priceB - priceA;
        });

        rows.forEach(row => tableBody.appendChild(row));
    }

    priceInput.addEventListener("input", filterTable);
    dateInput.addEventListener("change", filterTable);
    sortSelect.addEventListener("change", filterTable);
});
