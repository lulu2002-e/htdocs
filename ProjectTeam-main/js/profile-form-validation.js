document.querySelector('form')?.addEventListener('submit', function (e) {
    const name = document.getElementById('name')?.value.trim();
    const email = document.getElementById('email')?.value.trim();
    const profilePicture = document.getElementById('profile_picture')?.files?.[0];
    const oldPassword = document.getElementById('old_password')?.value.trim();
    const newPassword = document.getElementById('new_password')?.value.trim();
    const confirmPassword = document.getElementById('confirm_password')?.value.trim();

    let isValid = true;

    // Validate name
    if (!name) {
        alert("Name is required.");
        isValid = false;
    }

    // Validate email
    const emailPattern = /^[a-zA-Z0-9._%+-]+@uob\.edu$/;
    if (!email) {
        alert("Email is required.");
        isValid = false;
    } else if (!emailPattern.test(email)) {
        alert("Email must be a valid UoB email address.");
        isValid = false;
    }

    // Validate profile picture
    if (profilePicture) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        const maxSize = 2 * 1024 * 1024; // 2MB
        if (!allowedTypes.includes(profilePicture.type)) {
            alert("Profile picture must be a JPG, PNG, or GIF file.");
            isValid = false;
        } else if (profilePicture.size > maxSize) {
            alert("Profile picture must not exceed 2MB.");
            isValid = false;
        }
    }

    // Validate passwords
    if (newPassword || confirmPassword || oldPassword) {
        if (!oldPassword) {
            alert("Current password is required to change your password.");
            isValid = false;
        }

        if (newPassword.length < 8) {
            alert("New password must be at least 8 characters long.");
            isValid = false;
        }

        if (newPassword !== confirmPassword) {
            alert("New password and confirmation do not match.");
            isValid = false;
        }
    }

    // Prevent form submission if invalid
    if (!isValid) {
        e.preventDefault();
    }
});