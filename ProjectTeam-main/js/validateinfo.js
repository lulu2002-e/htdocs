document.getElementById("register-form").addEventListener("submit", function(event) {
    const password = document.getElementById("password").value;
    const username = document.getElementById("username").value;

    // Validate password
    if (password.length < 8) {
        alert("Password must be at least 8 characters long");
        event.preventDefault();
    }

    // Validate username (just an example)
    if (username.length < 4) {
        alert("Username must be at least 4 characters long");
        event.preventDefault();
    }
});
