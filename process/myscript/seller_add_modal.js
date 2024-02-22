
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