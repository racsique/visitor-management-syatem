
<?php
error_reporting(E_ALL);

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);
require_once __DIR__ . '/../../backend/includes/auth.php';
require_once __DIR__ . '/../../backend/config/database.php';

// Get date filters
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

// Get report summary
$summary_sql = "
    SELECT
        COUNT(*) AS total_visitors,
        SUM(CASE WHEN DATE(visit_date) = CURDATE() THEN 1 ELSE 0 END) AS today_visitors,
        SUM(CASE WHEN time_out IS NULL OR time_out = '' THEN 1 ELSE 0 END) AS checked_in,
        SUM(CASE WHEN time_out IS NOT NULL AND time_out != '' THEN 1 ELSE 0 END) AS checked_out
    FROM visitors
";

$summary_result = $conn->query($summary_sql);
$summary = $summary_result->fetch_assoc();

// Get visitor records
$sql = "SELECT * FROM visitors";
$params = [];
$types = "";

if ($start_date !== '' && $end_date !== '') {
    $sql .= " WHERE DATE(visit_date) BETWEEN ? AND ?";
    $params = [$start_date, $end_date];
    $types = "ss";
}

$sql .= " ORDER BY visit_date DESC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SecureGate - Reports</title>
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        .reports-container {
            padding: 30px;
        }

        .reports-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .reports-header h2 {
            color: #29213f;
            margin: 0;
        }

        .report-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 30px;
        }

        .report-card {
            background: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.06);
        }

        .report-card p {
            color: #777;
            margin: 0 0 10px;
        }

        .report-card h3 {
            color: #7346e8;
            font-size: 27px;
            margin: 0;
        }

        .filter-box {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .filter-box input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-right: 10px;
        }

        .report-btn {
            background: #7346e8;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        .report-table th,
        .report-table td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .report-table th {
            background: #7346e8;
            color: white;
        }

        .report-table td {
            color: #444;
        }

        .status-in {
            color: #16834a;
            font-weight: bold;
        }

        .status-out {
            color: #777;
            font-weight: bold;
        }

        @media (max-width: 900px) {
            .report-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media print {
            .filter-box, .print-button {
                display: none;
            }

            body {
                background: white !important;
            }

            .reports-container {
                padding: 0;
            }
        }
    </style>
</head>

<body>

<div class="reports-container">

    <div class="reports-header">
        <div>
            <h2>Visitor Reports</h2>
            <p>View and monitor visitor activity.</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">

    <a href="dashboard.php" class="report-btn back-dashboard-btn"
   style="text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
    <i class="bi bi-house-door"></i>
    Back to Dashboard
</a>

    <button class="report-btn print-button" onclick="window.print()">
        <i class="bi bi-printer"></i>
        Print Report
    </button>
</div>

</div>

        <button class="report-btn print-button" onclick="window.print()">
            Print Report
        </button>
    </div>

    <div class="report-cards">

        <div class="report-card">
            <p>Total Visitors</p>
            <h3><?= $summary['total_visitors'] ?? 0 ?></h3>
        </div>

        <div class="report-card">
            <p>Visitors Today</p>
            <h3><?= $summary['today_visitors'] ?? 0 ?></h3>
        </div>

        <div class="report-card">
            <p>Currently Checked In</p>
            <h3><?= $summary['checked_in'] ?? 0 ?></h3>
        </div>

        <div class="report-card">
            <p>Checked Out</p>
            <h3><?= $summary['checked_out'] ?? 0 ?></h3>
        </div>

    </div>

    <div class="filter-box">
        <form method="GET">
            <label>From:</label>
            <input type="date" name="start_date"
                   value="<?= htmlspecialchars($start_date) ?>" required>

            <label>To:</label>
            <input type="date" name="end_date"
                   value="<?= htmlspecialchars($end_date) ?>" required>

            <button type="submit" class="report-btn">Filter</button>

            <a href="reports.php">Clear</a>
        </form>
    </div>

    <h3>Visitor Records</h3>

    <table class="report-table">
        <thead>
            <tr>
                <th>Visitor Name</th>
                <th>Person to Visit</th>
                <th>Purpose</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>

            <?php while ($visitor = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($visitor['full_name'] ?? '') ?></td>
                    <td><?= htmlspecialchars($visitor['person_to_visit'] ?? '') ?></td>
                    <td><?= htmlspecialchars($visitor['purpose'] ?? '') ?></td>
                    <td><?= htmlspecialchars($visitor['visit_date'] ?? '') ?></td>
                    <td><?= htmlspecialchars($visitor['time_in'] ?? '') ?></td>
                    <td><?= htmlspecialchars($visitor['time_out'] ?? '—') ?></td>

                    <td>
                        <?php if (empty($visitor['time_out'])): ?>
                            <span class="status-in">Checked In</span>
                        <?php else: ?>
                            <span class="status-out">Checked Out</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>

        <?php else: ?>
            <tr>
                <td colspan="7">No visitor records found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</div>

</body>
</html>

<?php
$stmt->close();
?>
