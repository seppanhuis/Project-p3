function myFunction() {
    var input, filter, table, tr, td, i, txtValue, inputType, prijsArray;
    input = document.getElementById("myInput");
    inputType = document.getElementById("myInputType");
    filter = parseFloat(input.value) || 0;
    table = document.getElementById("table-leden");
    tr = Array.from(table.getElementsByTagName("tr"));
    prijsArray = [];

    // Verzamel alle prijzen en rijen in een array
    for (i = 1; i < tr.length; i++) { // Begin bij 1 om headers over te slaan
        td = tr[i].getElementsByTagName("td")[5]; // Kolom MaxAantalPersonen als prijs
        if (td) {
            txtValue = parseFloat(td.textContent || td.innerText);
            if (!isNaN(txtValue) && txtValue <= filter) {
                prijsArray.push({ row: tr[i], prijs: txtValue });
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    // Sorteer de array oplopend of aflopend
    prijsArray.sort(function (a, b) {
        return inputType.value == "0" ? a.prijs - b.prijs : b.prijs - a.prijs;
    });

    // Voeg de gesorteerde rijen terug toe aan de tabel
    for (i = 0; i < prijsArray.length; i++) {
        table.appendChild(prijsArray[i].row);
    }
}
