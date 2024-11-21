document.getElementById("user-btn").addEventListener("click", function() {
    const userBox = document.getElementById("user-box");
    userBox.style.display = userBox.style.display === "none" ? "block" : "none";
});

// ocultarlo si se hace clic fuera de él
document.addEventListener("click", function(event) {
    const userBox = document.getElementById("user-box");
    const userBtn = document.getElementById("user-btn");
    
    if (!userBox.contains(event.target) && !userBtn.contains(event.target)) {
        userBox.style.display = "none";
    }
});