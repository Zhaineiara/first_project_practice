<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="images/mifamilia_w.png"/>
        <title>Mi Familia</title>
        <link rel="stylesheet" href="design/seller-header.css"/>
        <link rel="stylesheet" href="design/seller-menu.css" />
        <link rel="stylesheet" href="design/add_product.css" />
        <link rel="stylesheet" href="design/edit_product.css" />
        <link rel="stylesheet" href="design/seller-menu.css" />

    </head>

    <body>
        <?php include "seller_header.php" ?>
        <?php include "snacks_menu_s.php" ?>
        <?php include "add_prod_snack.php" ?>

    </body>
</html>

<script>
/*Add modal*/
var openModalButtonAdd = document.getElementById("add-button");
var addprodmodal = document.getElementById("add-product_modal");
var closeModalButton3 = document.getElementById("x-button3");

openModalButtonAdd.addEventListener("click", function() {
    addprodmodal.style.display = "block";
    document.body.style.overflow = "hidden"; // Prevent scrolling
});

closeModalButton3.addEventListener("click", function() {
    addprodmodal.style.display = "none";
    document.body.style.overflow = ""; // Enable scrolling
});

window.addEventListener("click", function(event) {
    if (event.target === addprodmodal) {
        addprodmodal.style.display = "none";
        document.body.style.overflow = ""; // Enable scrolling
    }
});

</script>


<script src="process/myscript/seller_add_modal.js"></script>
<script src="process/myscript/seller_button.js"></script>