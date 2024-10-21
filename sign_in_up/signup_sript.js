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
