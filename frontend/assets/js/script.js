// SecureGate Login Page JavaScript

document.addEventListener("DOMContentLoaded", function () {

    // Get the login form
    const loginForm = document.querySelector("form");

    // Get username and password fields
    const username = document.getElementById("username");
    const password = document.getElementById("password");

    // Password visibility toggle
    const passwordBox = password.parentElement;

    const togglePassword = document.createElement("span");
    togglePassword.innerHTML = "👁️";
    togglePassword.style.cursor = "pointer";
    togglePassword.title = "Show password";

    passwordBox.appendChild(togglePassword);

    togglePassword.addEventListener("click", function () {

        if (password.type === "password") {
            password.type = "text";
            togglePassword.innerHTML = "🙈";
            togglePassword.title = "Hide password";
        } else {
            password.type = "password";
            togglePassword.innerHTML = "👁️";
            togglePassword.title = "Show password";
        }

    });


    // Basic form validation
    loginForm.addEventListener("submit", function (event) {

        const usernameValue = username.value.trim();
        const passwordValue = password.value.trim();

        if (usernameValue === "") {
            event.preventDefault();

            alert("Please enter your username.");
            username.focus();

            return;
        }

        if (passwordValue === "") {
            event.preventDefault();

            alert("Please enter your password.");
            password.focus();

            return;
        }

        // Login button feedback
        const loginButton = document.querySelector(".login-button");

        loginButton.innerHTML = "Logging in...";

    });

});