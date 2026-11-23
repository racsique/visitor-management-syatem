<?php
require_once '../../backend/includes/auth.php';
include '../../backend/config/database.php';
include '../../backend/includes/header.php';
include '../../backend/includes/navbar.php';
?>
<div class="dashboard-layout">
    <?php include '../../backend/includes/sidebar.php'; ?>

<main class="dashboard-content">

    <div class="dashboard-header">
        <div>
            <p class="dashboard-label">OVERVIEW</p>
            <h1>Dashboard</h1>
            <p>
                Welcome back, <?php echo htmlspecialchars($_SESSION['full_name'] ?? 'User'); ?>.
                Here's what's happening today.
            </p>
        </div>

        <a href="add_visitor.php" class="register-button">
            <i class="bi bi-plus-lg"></i>
            Register Visitor
        </a>
    </div>


    <!-- Statistics -->

    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="bi bi-people-fill"></i>
            </div>

            <div>
                <p>Total Visitors Today</p>
                <?php
                $today = date('Y-m-d');
                $result = $conn->query("SELECT COUNT(*) AS total FROM visitors WHERE visit_date = '$today'");
                $row = $result->fetch_assoc();
                ?>
                <h2><?php echo $row['total']; ?></h2>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon green">
                <i class="bi bi-person-check-fill"></i>
            </div>

            <div>
                <p>Currently Inside</p>
                <?php
                $result = $conn->query("SELECT COUNT(*) AS total FROM visitors WHERE status = 'Inside'");
                $row = $result->fetch_assoc();
                ?>
                <h2><?php echo $row['total']; ?></h2>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="bi bi-box-arrow-right"></i>
            </div>

            <div>
                <p>Checked Out</p>
                <?php
                $today = date('Y-m-d');
                $stmt = $conn->prepare(
                    "SELECT COUNT(*) AS total FROM visitors WHERE visit_date = ? AND status = 'Checked Out'"
                );
                $stmt->bind_param("s", $today);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                ?>
                <h2><?php echo $row['total']; ?></h2>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-building"></i>
            </div>

            <div>
                <p>Departments</p>
                <h2>5</h2>
            </div>
        </div>

    </div>


    <!-- Quick Actions -->

    <div class="section-heading">
        <div>
            <h3>Quick Actions</h3>
            <p>Common visitor management tasks</p>
        </div>
    </div>


    <div class="quick-actions">

        <a href="add_visitor.php" class="action-card">
            <div class="action-icon">
                <i class="bi bi-person-plus-fill"></i>
            </div>

            <div>
                <strong>Register Visitor</strong>
                <span>Add a new visitor</span>
            </div>

            <i class="bi bi-arrow-right"></i>
        </a>


        <a href="visitors.php" class="action-card">
            <div class="action-icon">
                <i class="bi bi-clipboard-data-fill"></i>
            </div>

            <div>
                <strong>Visitor Records</strong>
                <span>View visitor history</span>
            </div>

            <i class="bi bi-arrow-right"></i>
        </a>


        <a href="visitors.php" class="action-card">
            <div class="action-icon">
                <i class="bi bi-person-check-fill"></i>
            </div>

            <div>
                <strong>Currently Inside</strong>
                <span>See who is inside</span>
            </div>

            <i class="bi bi-arrow-right"></i>
        </a>

    </div>


    <!-- Recent Visitors -->

    <div class="recent-section">

        <div class="section-heading">
            <div>
                <h3>Recent Visitors</h3>
                <p>Latest visitor activity</p>
            </div>

            <a href="visitors.php">View All</a>
        </div>


        <div class="visitor-table">

            <table>

                <thead>
                    <tr>
                        <th>Visitor</th>
                        <th>Department</th>
                        <th>Purpose</th>
                        <th>Check-In</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                $sql = "SELECT full_name, department, person_to_visit, purpose, time_in, status
                        FROM visitors
                        ORDER BY visit_date DESC, time_in DESC
                        LIMIT 5";

                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0):
                    while ($visitor = $result->fetch_assoc()):
                        $initials = '';
                        $nameParts = explode(' ', trim($visitor['full_name']));

                        foreach ($nameParts as $part) {
                            if ($part !== '') {
                                $initials .= strtoupper(substr($part, 0, 1));
                            }
                        }

                        $initials = substr($initials, 0, 2);
                ?>
                    <tr>
                        <td>
                            <div class="visitor-name">
                                <div class="visitor-avatar">
                                    <?php echo htmlspecialchars($initials); ?>
                                </div>
                                <strong>
                                    <?php echo htmlspecialchars($visitor['full_name']); ?>
                                </strong>
                            </div>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($visitor['department'] ?: $visitor['person_to_visit']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($visitor['purpose']); ?>
                        </td>

                        <td>
                            <?php echo date('h:i A', strtotime($visitor['time_in'])); ?>
                        </td>

                        <td>
                            <?php
                            $status_class = 'checked-out';
                            if ($visitor['status'] === 'Inside') {
                                $status_class = 'inside';
                            } elseif ($visitor['status'] === 'Expected') {
                                $status_class = 'expected';
                            }
                            ?>
                            <span class="status <?php echo $status_class; ?>">
                                <span></span>
                                <?php echo htmlspecialchars($visitor['status']); ?>
                            </span>
                        </td>
                    </tr>
                <?php
                    endwhile;
                else:
                ?>
                    <tr>
                        <td colspan="5">No visitors registered yet.</td>
                    </tr>
                <?php endif; ?>
                </tbody>

            </table>

        </div>

    </div>

</main>
