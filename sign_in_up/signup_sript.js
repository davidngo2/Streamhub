    let selectedSubscription = "";

    function highlightRow(rowNumber) {
        selectedSubscription = rowNumber;
        const cells = document.querySelectorAll(
            ".price1, .quality1, .resolution1, .check1, .price2, .quality2, .resolution2, .check2, .price3, .quality3, .resolution3, .check3"
        );

        cells.forEach((cell) => {
            cell.classList.remove("highlight");
        });

        if (rowNumber == 1) {
            const selectedCells = document.querySelectorAll(
                `#row1 .price1, #row2 .quality1, #row3 .resolution1, #row4 .check1`
            );

            selectedCells.forEach((cell) => {
                cell.classList.add("highlight");
            });
        } else if (rowNumber == 2) {
            const selectedCells = document.querySelectorAll(
                `#row1 .price2, #row2 .quality2, #row3 .resolution2, #row4 .check2`
            );

            selectedCells.forEach((cell) => {
                cell.classList.add("highlight");
            });
        } else if (rowNumber == 3) {
            const selectedCells = document.querySelectorAll(
                `#row1 .price3, #row2 .quality3, #row3 .resolution3, #row4 .check3`
            );

            selectedCells.forEach((cell) => {
                cell.classList.add("highlight");
            });
        }
    }

    function redirectToSignUp() {
        if (selectedSubscription !== "") {
            window.location.href =
                "sign_up_user.php?subscription=" + selectedSubscription;
        } else {
            alert("Please select a subscription before proceeding.");
        }
    }


    var visaOption = document.getElementById("visaOption");
    var visaForm = document.getElementById("visaForm");

    var mastercardOption = document.getElementById("mastercardOption");
    var mastercardForm = document.getElementById("mastercardForm");

    var idealOption = document.getElementById("idealOption");
    var idealForm = document.getElementById("idealForm");

    // Function to hide all forms
    function hideForms() {
        visaForm.classList.add("hidden");
        mastercardForm.classList.add("hidden");
        idealForm.classList.add("hidden");
    }

    // Add event listeners for Visa radio button
    visaOption.addEventListener("change", function () {
        if (this.checked) {
            hideForms(); // Hide all forms
            visaForm.classList.remove("hidden"); // Show Visa form
        }
    });

    // Add event listeners for Mastercard radio button
    mastercardOption.addEventListener("change", function () {
        if (this.checked) {
            hideForms(); // Hide all forms
            mastercardForm.classList.remove("hidden"); // Show Mastercard form
        }
    });

    // Add event listeners for iDEAL radio button
    idealOption.addEventListener("change", function () {
        if (this.checked) {
            hideForms(); // Hide all forms
            idealForm.classList.remove("hidden"); // Show iDEAL form
        }
    });

    // Add event listener to hide all forms when no option is selected
    document
        .querySelectorAll('input[name="payment"]')
        .forEach(function (radio) {
            radio.addEventListener("change", function () {
                if (
                    !visaOption.checked &&
                    !mastercardOption.checked &&
                    !idealOption.checked
                ) {
                    hideForms(); // Hide all forms when no option is selected
                }
            });
        });
