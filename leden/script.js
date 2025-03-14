// filter op naam van een lid

function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    inputType = document.getElementById("myInputType");
    filter = input.value.toUpperCase();
    table = document.getElementById("table-leden");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[inputType.value];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

// zorg dat alle velden verplicht ingevuld moeten zijn
document.querySelector("form").addEventListener("submit", function(event) {
    let inputs = document.querySelectorAll("input[required]");
    let valid = true;

    inputs.forEach(input => {
        if (input.value.trim() === "") {
            valid = false;
            input.classList.add("is-invalid"); 
        } else {
            input.classList.remove("is-invalid");
        }
    });

    if (!valid) {
        event.preventDefault();
        alert("Vul alle verplichte velden in!");
    }
});


