
        // Function to handle button click and redirect
        function redirectToPage(page) {
            window.location.href = page;
        }

        // Attach click event handlers to each button
        document.getElementById("menu-button").addEventListener("click", function() {
            redirectToPage("seller.php");
        });

        document.getElementById("silog-button").addEventListener("click", function() {
            redirectToPage("silog_s.php");
        });

        document.getElementById("snack-button").addEventListener("click", function() {
            redirectToPage("snacks_s.php");
        });

        document.getElementById("drink-button").addEventListener("click", function() {
            redirectToPage("drinks_s.php");
        });

        document.getElementById("additional-button").addEventListener("click", function() {
            redirectToPage("additional_s.php");
        });

        document.getElementById("order-button").addEventListener("click", function() {
            redirectToPage("order.php");
        });

        document.getElementById("chart-button").addEventListener("click", function() {
            redirectToPage("chart.php");
        });



