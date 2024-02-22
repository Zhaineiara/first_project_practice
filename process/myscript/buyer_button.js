
        // Function to handle button click and redirect
        function redirectToPage(page) {
            window.location.href = page;
        }

        // Attach click event handlers to each button
        document.getElementById("menu-button").addEventListener("click", function() {
            redirectToPage("buyer.php");
        });

        document.getElementById("silog-button").addEventListener("click", function() {
            redirectToPage("silog_b.php");
        });

        document.getElementById("snack-button").addEventListener("click", function() {
            redirectToPage("snacks_b.php");
        });

        document.getElementById("drink-button").addEventListener("click", function() {
            redirectToPage("drinks_b.php");
        });

        document.getElementById("additional-button").addEventListener("click", function() {
            redirectToPage("additional_b.php");
        });

        document.getElementById("bag-button").addEventListener("click", function() {
            redirectToPage("bag.php");
        });

        document.getElementById("cart-button").addEventListener("click", function() {
            redirectToPage("cart.php");
        });