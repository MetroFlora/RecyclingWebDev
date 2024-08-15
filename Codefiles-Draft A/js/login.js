document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('.form-login');

    if (loginForm) {
        loginForm.addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(loginForm);
            const response = await fetch('login.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                alert('You have successfully logged in!');
                window.location.href = 'index.html'; // Redirect to homepage or another page
            } else {
                alert('Login failed: ' + result.message);
            }
        });
    }
});
