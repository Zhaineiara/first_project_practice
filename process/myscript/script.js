/*Log in modal and blurred background*/
var openModalButton1 = document.getElementById("login-btn");
var modal1 = document.getElementById("login_modal");
var closeModalButton1 = document.getElementById("x-button1");
var overlay = document.getElementById("overlay"); // Added overlay reference

openModalButton1.addEventListener("click", function() {
    modal1.style.display = "block";
    document.body.style.overflow = "hidden"; // Prevent scrolling
    overlay.style.pointerEvents = "auto"; // Enable overlay interaction
    document.body.classList.add("modal-open"); // Add class for blur effect
});

closeModalButton1.addEventListener("click", function() {
    modal1.style.display = "none";
    document.body.style.overflow = ""; // Enable scrolling
    overlay.style.pointerEvents = "none"; // Disable overlay interaction
    document.body.classList.remove("modal-open"); // Remove class for blur effect
});

window.addEventListener("click", function(event) {
    if (event.target === modal1) {
        modal1.style.display = "none";
        document.body.style.overflow = ""; // Enable scrolling
        overlay.style.pointerEvents = "none"; // Disable overlay interaction
        document.body.classList.remove("modal-open"); // Remove class for blur effect
    }
});

