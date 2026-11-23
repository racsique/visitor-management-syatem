<?php
include '../backend/config/database.php';

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $gender = $_POST['gender'];
    $phone = trim($_POST['phone']);
    $id_number = trim($_POST['id_number']);
    $purpose = trim($_POST['purpose']);
    $department = trim($_POST['department']);

    $full_name = trim($first_name . " " . $last_name);

    $stmt = $conn->prepare(
        "INSERT INTO visitors
        (first_name, last_name, email, gender, id_number, department,
         full_name, phone, person_to_visit, purpose, visit_date, time_in, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE(), CURTIME(), 'Expected')"
    );

    if ($stmt === false) {
        $message = "Error: " . $conn->error;
        $message_type = "error";
    } else {
        $stmt->bind_param(
            "ssssssssss",
            $first_name, $last_name, $email, $gender, $id_number, $department,
            $full_name, $phone, $department, $purpose
        );

        if ($stmt->execute()) {
            $message = "Your visit request has been submitted successfully!";
            $message_type = "success";
        } else {
            $message = "Error: " . $stmt->error;
            $message_type = "error";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Visitor Registration - SecureGate</title>

    <link rel="stylesheet" href="../frontend/assets/css/style.css?v=4">
</head>

<body class="add-visitor-page" style="background: #f5f1ff !important;">

    <main class="add-visitor-content">

        <!-- PAGE HEADER -->
        <div class="add-visitor-header">

            <div class="add-visitor-label">
                VISITOR MANAGEMENT
            </div>

            <h1>Visitor Registration</h1>

            <p>
                Fill in the form below to register your visit.
            </p>

        </div>


        <!-- SUCCESS / ERROR MESSAGE -->

        <?php if ($message != ""): ?>

            <div class="<?php echo $message_type == 'success' ? 'success-message' : 'error-message'; ?>">
                <?php echo htmlspecialchars($message); ?>
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
                        Enter your details below. Fields marked * are required.
                    </p>
                </div>

            </div>


            <!-- FORM -->

            <form method="POST" class="visitor-form">

                <!-- FIRST NAME -->

                <div class="form-group">

                    <label for="first_name">
                        First Name *
                    </label>

                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        placeholder="Enter your first name"
                        required>

                </div>


                <!-- LAST NAME -->

                <div class="form-group">

                    <label for="last_name">
                        Last Name *
                    </label>

                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        placeholder="Enter your last name"
                        required>

                </div>


                <!-- EMAIL -->

                <div class="form-group">

                    <label for="email">
                        Email *
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="e.g. you@example.com"
                        required>

                </div>


                <!-- GENDER -->

                <div class="form-group">

                    <label for="gender">
                        Gender *
                    </label>

                    <select
                        id="gender"
                        name="gender"
                        required>
                        <option value="">Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>

                </div>


                <!-- PHONE -->

                <div class="form-group">

                    <label for="phone">
                        Phone Number *
                    </label>

                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        placeholder="e.g. 0712345678"
                        required>

                </div>


                <!-- ID NUMBER -->

                <div class="form-group">

                    <label for="id_number">
                        ID Number *
                    </label>

                    <input
                        type="text"
                        id="id_number"
                        name="id_number"
                        placeholder="Enter your national ID / passport number"
                        required>

                </div>


                <!-- DEPARTMENT -->

                <div class="form-group">

                    <label for="department">
                        Department Visiting *
                    </label>

                    <input
                        type="text"
                        id="department"
                        name="department"
                        list="department-list"
                        placeholder="e.g. Finance, ICT, HR"
                        required>

                    <datalist id="department-list">
                        <option value="Administration"></option>
                        <option value="Finance"></option>
                        <option value="Human Resources"></option>
                        <option value="ICT"></option>
                        <option value="Library"></option>
                        <option value="Registrar"></option>
                    </datalist>

                </div>


                <!-- PURPOSE -->

                <div class="form-group full-width">

                    <label for="purpose">
                        Purpose of Visit *
                    </label>

                    <textarea
                        id="purpose"
                        name="purpose"
                        placeholder="Briefly describe the purpose of your visit..."
                        required></textarea>

                </div>


                <!-- BUTTONS -->

                <div class="form-actions">

                    <button
                        type="submit"
                        class="add-visitor-button">
                        Submit Visit Request
                    </button>

                </div>

            </form>

        </div>

    </main>

</body>

</html>
