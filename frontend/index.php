<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$full_name = $_SESSION["full_name"];
$role = $_SESSION["role"];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Visitor Management System</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <script src="assets/js/script.js" defer></script>

</head>

<body class="dashboard-page">

    <!-- Sidebar -->

    <aside class="sidebar">

        <div class="sidebar-brand">

            <div class="brand-icon">
                🛡️
            </div>

            <span>
                Visitor<br>
                Management
            </span>

        </div>


        <nav class="sidebar-nav">

            <a href="index.php" class="nav-item active">
                🏠
                <span>Dashboard</span>
            </a>

            <a href="pages/add_visitor.php" class="nav-item">
                👤
                <span>Register Visitor</span>
            </a>

            <a href="#" class="nav-item">
                📋
                <span>Visitor Records</span>
            </a>

            <a href="#" class="nav-item">
                🟢
                <span>Currently Inside</span>
            </a>

            <?php if ($role === "admin"): ?>

                <a href="#" class="nav-item">
                    👥
                    <span>Manage Users</span>
                </a>

            <?php endif; ?>

        </nav>


        <div class="sidebar-bottom">

            <a href="logout.php" class="nav-item logout">
                🚪
                <span>Logout</span>
            </a>

        </div>

    </aside>


    <!-- Main content -->

    <main class="dashboard-main">

        <!-- Top bar -->

        <header class="dashboard-header">

            <div>

                <p class="dashboard-label">
                    Visitor Management System
                </p>

                <h1>
                    Dashboard
                </h1>

            </div>


            <div class="user-profile">

                <div class="profile-icon">
                    👤
                </div>

                <div>

                    <strong>
                        <?php echo htmlspecialchars($full_name); ?>
                    </strong>

                    <small>
                        <?php echo htmlspecialchars($role); ?>
                    </small>

                </div>

            </div>

        </header>


        <!-- Welcome -->

        <section class="welcome-banner">

            <div>

                <p class="small-title">
                    Welcome back 👋
                </p>

                <h2>
                    <?php echo htmlspecialchars($full_name); ?>
                </h2>

                <p>
                    Manage and monitor visitors easily from your dashboard.
                </p>

            </div>

            <div class="welcome-emoji">
                🛡️
            </div>

        </section>


        <!-- Statistics -->

        <section class="statistics-grid">

            <div class="stat-card">

                <div class="stat-icon visitors">
                    👥
                </div>

                <div>

                    <p>
                        Total Visitors
                    </p>

                    <h3>
                        0
                    </h3>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon inside">
                    🟢
                </div>

                <div>

                    <p>
                        Currently Inside
                    </p>

                    <h3>
                        0
                    </h3>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon checked-out">
                    🚪
                </div>

                <div>

                    <p>
                        Checked Out
                    </p>

                    <h3>
                        0
                    </h3>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon today">
                    📅
                </div>

                <div>

                    <p>
                        Today's Visitors
                    </p>

                    <h3>
                        0
                    </h3>

                </div>

            </div>

        </section>


        <!-- Quick actions -->

        <section class="dashboard-section">

            <div class="section-heading">

                <div>

                    <h2>
                        Quick Actions
                    </h2>

                    <p>
                        Common visitor management tasks
                    </p>

                </div>

            </div>


            <div class="quick-actions">

                <a href="pages/add_visitor.php" class="action-card">

                    <span class="action-icon">
                        ➕
                    </span>

                    <div>

                        <strong>
                            Register Visitor
                        </strong>

                        <p>
                            Add a new visitor
                        </p>

                    </div>

                    <span class="arrow">
                        →
                    </span>

                </a>


                <a href="#" class="action-card">

                    <span class="action-icon">
                        📋
                    </span>

                    <div>

                        <strong>
                            Visitor Records
                        </strong>

                        <p>
                            View visitor history
                        </p>

                    </div>

                    <span class="arrow">
                        →
                    </span>

                </a>


                <a href="#" class="action-card">

                    <span class="action-icon">
                        🟢
                    </span>

                    <div>

                        <strong>
                            Current Visitors
                        </strong>

                        <p>
                            See who is inside
                        </p>

                    </div>

                    <span class="arrow">
                        →
                    </span>

                </a>

            </div>

        </section>


        <!-- Recent visitors -->

        <section class="dashboard-section">

            <div class="section-heading">

                <div>

                    <h2>
                        Recent Visitors
                    </h2>

                    <p>
                        Latest visitor activity
                    </p>

                </div>

            </div>


            <div class="empty-state">

                <div class="empty-icon">
                    📋
                </div>

                <h3>
                    No visitors yet
                </h3>

                <p>
                    Registered visitors will appear here.
                </p>

                <a href="pages/add_visitor.php" class="primary-button">
                    + Register First Visitor
                </a>

            </div>

        </section>

    </main>

</body>

</html>