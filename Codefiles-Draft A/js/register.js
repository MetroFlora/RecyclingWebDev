document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.querySelector('.form-register');

    if (registerForm) {
        registerForm.addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(registerForm);
            const response = await fetch('register.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                alert('Registration successful!');
                window.location.href = 'login.html'; // Redirect to login page or another page
            } else {
                alert('Registration failed: ' + result.message);
            }
        });
    }
});