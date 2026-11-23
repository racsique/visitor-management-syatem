<?php
require_once '../../backend/includes/auth.php';
include '../../backend/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['visitor_id'])) {

    $visitor_id = (int) $_POST['visitor_id'];

    $stmt = $conn->prepare(
        "UPDATE visitors
         SET time_out = CURRENT_TIME(), status = 'Checked Out'
         WHERE id = ? AND status = 'Inside'"
    );

    if (!$stmt) {
        die("Checkout error: " . $conn->error);
    }

    $stmt->bind_param("i", $visitor_id);

    if (!$stmt->execute()) {
        die("Checkout failed: " . $stmt->error);
    }

    $stmt->close();
}

header("Location: visitors.php");
exit;
?>
