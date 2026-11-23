<?php

session_start();

require_once __DIR__ . "/../backend/config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");

    $stmt = $conn->prepare(
        "SELECT id, username, password, full_name, role
         FROM users
         WHERE username = ?"
    );

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        if ($password === $user["password"]) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["full_name"] = $user["full_name"];
            $_SESSION["role"] = $user["role"];

            header("Location:pages/dashboard.php");
            exit();

        } else {

            $error = "Incorrect password.";

        }

    } else {

        $error = "Username not found.";

    }

    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Visitors Management System | Login</title>

    <link rel="stylesheet" href="/visitor-management-system/frontend/assets/css/style.css?v=2">

    <script src="assets/js/script.js" defer></script>

</head>

<body class="login-page">

    <div class="background-shape shape-one"></div>
    <div class="background-shape shape-two"></div>

    <div class="login-container">

        <!-- Left side -->

        <div class="welcome-section">

            <div class="brand">

                <div class="brand-icon">
                    🛡️
                </div>

                <span>
                    Secure<span>Gate</span>
                </span>

            </div>

            <h1>
                Visitors<br>
                <span>Management</span><br>
                System
            </h1>

            <p class="tagline">
                Smart. Secure. Seamless.
            </p>

            <p class="description">
                Welcome every visitor with safety,
                efficiency and ease.
            </p>

            <div class="welcome-box">

                <span>✨</span>

                <div>

                    <strong>
                        Safety. Security. Trust.
                    </strong>

                    <p>
                        Keeping your visitors safe and organized.
                    </p>

                </div>

            </div>

        </div>


        <!-- Login card -->

        <div class="login-card">

            <div class="login-icon">
                🔐
            </div>

            <h2>
                Welcome Back!
            </h2>

            <p class="login-subtitle">
                Please sign in to continue
            </p>


            <?php if ($error !== ""): ?>

                <div class="error-message">

                    <?php echo htmlspecialchars($error); ?>

                </div>

            <?php endif; ?>


            <form action="login.php" method="POST">

                <div class="input-group">

                    <label for="username">
                        Username
                    </label>

                    <div class="input-box">

                        <span>👤</span>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Enter your username"
                            required
                        >

                    </div>

                </div>


                <div class="input-group">

                    <label for="password">
                        Password
                    </label>

                    <div class="input-box">

                        <span>🔒</span>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                        >

                    </div>

                </div>


                <div class="login-options">

                    <label>

                        <input
                            type="checkbox"
                            name="remember"
                        >

                        Remember me

                    </label>

                    <a href="forgot_password.php">
                        Forgot Password?
                    </a>

                </div>


                <button
                    type="submit"
                    class="login-button"
                >

                    Login

                    <span>→</span>

                </button>

            </form>


            <div class="login-footer">

                <span>🛡️</span>

                 Secure Gate

            </div>

        </div>

    </div>

</body>

</html>

