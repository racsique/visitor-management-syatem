<?php
require_once '../../backend/includes/auth.php';
include '../../backend/config/database.php';

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $person_to_visit = $_POST['person_to_visit'];
    $purpose = $_POST['purpose'];
    $visit_date = $_POST['visit_date'];
    $time_in = $_POST['time_in'];

    $sql = "INSERT INTO visitors 
            (full_name, phone, person_to_visit, purpose, visit_date, time_in)
            VALUES 
            ('$full_name', '$phone', '$person_to_visit', '$purpose', '$visit_date', '$time_in')";

    if ($conn->query($sql) === TRUE) {
        $message = "Visitor added successfully!";
        $message_type = "success";
    } else {
        $message = "Error: " . $conn->error;
        $message_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Visitor - SecureGate</title>

    <link rel="stylesheet" href="../assets/css/style.css?v=4">
</head>

<body class="add-visitor-page" style="background: #f5f1ff !important;">

    <main class="add-visitor-content">

        <!-- PAGE HEADER -->
        <div class="add-visitor-header">

            <div class="add-visitor-label">
                VISITOR MANAGEMENT
            </div>

            <h1>Add Visitor</h1>

            <p>
                Register a new visitor and record their visit details.
            </p>

        </div>


        <!-- SUCCESS / ERROR MESSAGE -->

        <?php if ($message != ""): ?>

            <div class="<?php echo $message_type == 'success' ? 'success-message' : 'error-message'; ?>">
                <?php echo $message; ?>
            </div>

        <?php endif; ?>


        <!-- FORM CARD -->

        <div class="add-visitor-card">

            <div class="form-heading">

                <div class="form-heading-icon">
                    +
                </div>

                <div>
                    <h2>Visitor Information</h2>

                    <p>
                        Enter the details of the visitor below.
                    </p>
                </div>

            </div>


            <!-- FORM -->

            <form method="POST" class="visitor-form">

                <!-- FULL NAME -->

                <div class="form-group">

                    <label for="full_name">
                        Full Name
                    </label>

                    <input
                        type="text"
                        id="full_name"
                        name="full_name"
                        placeholder="Enter visitor's full name"
                        required>

                </div>


                <!-- PHONE -->

                <div class="form-group">

                    <label for="phone">
                        Phone Number
                    </label>

                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        placeholder="e.g. 0712345678"
                        required>

                </div>


                <!-- PERSON TO VISIT -->

                <div class="form-group">

                    <label for="person_to_visit">
                        Person to Visit
                    </label>

                    <input
                        type="text"
                        id="person_to_visit"
                        name="person_to_visit"
                        placeholder="Name of employee"
                        required>

                </div>


                <!-- VISIT DATE -->

                <div class="form-group">

                    <label for="visit_date">
                        Visit Date
                    </label>

                    <input
                        type="date"
                        id="visit_date"
                        name="visit_date"
                        required>

                </div>


                <!-- TIME IN -->

                <div class="form-group">

                    <label for="time_in">
                        Time In
                    </label>

                    <input
                        type="time"
                        id="time_in"
                        name="time_in"
                        required>

                </div>


                <!-- PURPOSE -->

                <div class="form-group full-width">

                    <label for="purpose">
                        Purpose of Visit
                    </label>

                    <textarea
                        id="purpose"
                        name="purpose"
                        placeholder="Briefly describe the purpose of the visit..."
                        required></textarea>

                </div>


                <!-- BUTTONS -->

                <div class="form-actions">

                    <a href="dashboard.php" class="cancel-button">
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="add-visitor-button">
                        Add Visitor
                    </button>

                </div>

            </form>

        </div>

    </main>

</body>

</html>


