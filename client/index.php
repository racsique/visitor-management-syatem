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
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE(), CURTIME(), 'Inside')"
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

    <title>SecureGate | Visitor Registration</title>

    <link rel="stylesheet" href="../admin/frontend/assets/css/style.css?v=4">

    <link rel="stylesheet" href="css/style.css?v=3">
</head>

<body class="add-visitor-page" style="background: #F3F6F4 !important;">

    <!-- NAVBAR -->
    <nav class="navbar">

        <div class="navbar-inner">

            <a href="index.php" class="navbar-brand">
                <img src="logo.png" alt="SecureGate Logo">
            </a>

            <button class="nav-toggle" id="navToggle" aria-label="Toggle menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <ul class="nav-menu" id="navMenu">
                <li><a href="#top" class="active">Home</a></li>
                <li><a href="#register">Visitor Registration</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>

        </div>

    </nav>

    <main class="add-visitor-content" id="top">

        <!-- LANDING HERO -->
        <div class="client-hero">

            <h1>Welcome, Visitor</h1>

            <p>
                Please register your visit before heading to the front desk.
                It only takes a minute and helps us keep everyone safe.
            </p>

            <div class="steps">
                <div class="step"><span class="num">1</span> Fill in the form</div>
                <div class="step"><span class="num">2</span> Submit your request</div>
                <div class="step"><span class="num">3</span> Collect your pass at reception</div>
            </div>

        </div>


        <!-- PAGE HEADER -->
        <div class="add-visitor-header" id="register">

            <div class="add-visitor-label">
                VISITOR REGISTRATION
            </div>

            

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
                        pattern="^[A-Za-z]+( [A-Za-z]+)*$"
                        title="Letters and spaces only"
                        maxlength="50"
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
                        pattern="^[A-Za-z]+( [A-Za-z]+)*$"
                        title="Letters and spaces only"
                        maxlength="50"
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

                    <div class="email-suggestions" id="emailSuggestions"></div>

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
                        maxlength="10"
                        inputmode="numeric"
                        pattern="^[07][0-9]{9}$"
                        title="Enter a 10-digit Kenyan number starting with 0 or 7, e.g. 0712345678"
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

    <!-- FOOTER -->
    <footer class="site-footer" id="contact">

        <div class="footer-inner">

            <div class="footer-brand">
                SecureGate Visitor Management
            </div>

            <div class="footer-contact">

                <a href="mailto:hellovms@gmail.com">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/>
                    </svg>
                    hellovms@gmail.com
                </a>

                <a href="tel:0712345678">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24c1.12.37 2.33.57 3.57.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.61 21 3 13.39 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.24.2 2.45.57 3.57a1 1 0 0 1-.25 1.02l-2.2 2.2z"/>
                    </svg>
                    0712345678
                </a>

                <span>
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/>
                    </svg>
                    Nairobi, Kenya
                </span>

            </div>

            <div class="social-icons">

                <a href="#" aria-label="TikTok" target="_blank" rel="noopener">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5.8 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1.84-.1z"/>
                    </svg>
                </a>

                <a href="#" aria-label="Instagram" target="_blank" rel="noopener">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41a3.72 3.72 0 0 1-1.38-.9 3.72 3.72 0 0 1-.9-1.38c-.16-.42-.36-1.06-.41-2.23C2.17 15.58 2.16 15.2 2.16 12s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41C8.42 2.17 8.8 2.16 12 2.16zM12 0C8.74 0 8.33.01 7.05.07 5.78.13 4.9.33 4.14.63c-.79.3-1.46.72-2.12 1.38A5.87 5.87 0 0 0 .63 4.14C.33 4.9.13 5.78.07 7.05.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.06 1.27.26 2.15.56 2.91.3.79.72 1.46 1.38 2.12.66.66 1.33 1.08 2.12 1.38.76.3 1.64.5 2.91.56C8.33 23.99 8.74 24 12 24s3.67-.01 4.95-.07c1.27-.06 2.15-.26 2.91-.56.79-.3 1.46-.72 2.12-1.38.66-.66 1.08-1.33 1.38-2.12.3-.76.5-1.64.56-2.91.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.06-1.27-.26-2.15-.56-2.91a5.87 5.87 0 0 0-1.38-2.12A5.87 5.87 0 0 0 19.86.63C19.1.33 18.22.13 16.95.07 15.67.01 15.26 0 12 0zm0 5.84A6.16 6.16 0 1 0 18.16 12 6.16 6.16 0 0 0 12 5.84zm0 10.15A4 4 0 1 1 16 12a4 4 0 0 1-4 4zm7.85-10.4a1.44 1.44 0 1 1-2.88 0 1.44 1.44 0 0 1 2.88 0z"/>
                    </svg>
                </a>

                <a href="#" aria-label="Twitter" target="_blank" rel="noopener">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M18.9 2H22l-6.77 7.74L23.2 22h-6.24l-4.89-6.4L6.47 22H3.35l7.25-8.29L1.2 2h6.4l4.42 5.85L18.9 2zm-1.1 18h1.72L7.7 3.9H5.85L17.8 20z"/>
                    </svg>
                </a>

            </div>

        </div>

        <div class="footer-bottom">
            &copy; <?php echo date("Y"); ?> SecureGate Visitor Management. All rights reserved.
        </div>

    </footer>

    <script>
        const navToggle = document.getElementById('navToggle');
        const navMenu = document.getElementById('navMenu');

        navToggle.addEventListener('click', function () {
            const isOpen = navMenu.classList.toggle('open');
            navToggle.classList.toggle('open', isOpen);
            navToggle.setAttribute('aria-expanded', isOpen);
        });

        navMenu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                navMenu.classList.remove('open');
                navToggle.classList.remove('open');
                navToggle.setAttribute('aria-expanded', 'false');
            });
        });

        // Email domain suggestions
        const emailInput = document.getElementById('email');
        const emailSuggestions = document.getElementById('emailSuggestions');
        const emailDomains = ['gmail.com', 'yahoo.com', 'icloud.com', 'hotmail.com', 'outlook.com'];
        let activeIndex = -1;

        function hideEmailSuggestions() {
            emailSuggestions.classList.remove('open');
            emailSuggestions.innerHTML = '';
            activeIndex = -1;
        }

        function showEmailSuggestions(localPart, partial) {
            const matches = emailDomains.filter(function (d) {
                return d.startsWith(partial.toLowerCase());
            });

            if (!matches.length) {
                hideEmailSuggestions();
                return;
            }

            emailSuggestions.innerHTML = matches.map(function (d) {
                return '<button type="button" data-domain="' + d + '">@' + d + '</button>';
            }).join('');
            emailSuggestions.classList.add('open');
            activeIndex = -1;
        }

        emailInput.addEventListener('input', function () {
            const value = emailInput.value;
            const atIndex = value.lastIndexOf('@');

            if (atIndex === -1 || atIndex === value.length - 1) {
                hideEmailSuggestions();
                return;
            }

            const localPart = value.slice(0, atIndex);
            const partial = value.slice(atIndex + 1);

            if (localPart.length === 0 || partial.indexOf(' ') !== -1) {
                hideEmailSuggestions();
                return;
            }

            showEmailSuggestions(localPart, partial);
        });

        emailInput.addEventListener('keydown', function (e) {
            const items = emailSuggestions.querySelectorAll('button');
            if (!items.length) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                activeIndex = (activeIndex + 1) % items.length;
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                activeIndex = (activeIndex - 1 + items.length) % items.length;
            } else if (e.key === 'Enter' && activeIndex > -1) {
                e.preventDefault();
                items[activeIndex].click();
                return;
            } else if (e.key === 'Escape') {
                hideEmailSuggestions();
                return;
            } else {
                return;
            }

            items.forEach(function (item, i) {
                item.classList.toggle('active', i === activeIndex);
            });
        });

        emailSuggestions.addEventListener('mousedown', function (e) {
            const btn = e.target.closest('button[data-domain]');
            if (!btn) return;

            const atIndex = emailInput.value.lastIndexOf('@');
            emailInput.value = emailInput.value.slice(0, atIndex + 1) + btn.dataset.domain;
            hideEmailSuggestions();
            emailInput.focus();
        });

        // Names: letters and spaces only
        ['first_name', 'last_name'].forEach(function (id) {
            const input = document.getElementById(id);
            input.addEventListener('input', function () {
                input.value = input.value.replace(/[^A-Za-z ]/g, '').replace(/\s+/g, ' ').slice(0, 50);
            });
        });

        // Phone number: Kenyan format, digits only, 10 digits starting with 0 or 7
        const phoneInput = document.getElementById('phone');

        phoneInput.addEventListener('input', function () {
            let digits = phoneInput.value.replace(/\D/g, '');

            // Strip +254 / 254 country code if pasted
            if (digits.startsWith('254') && digits.length > 10) {
                digits = digits.slice(3);
            }

            phoneInput.value = digits.slice(0, 10);
        });

        document.addEventListener('click', function (e) {
            if (!emailSuggestions.contains(e.target) && e.target !== emailInput) {
                hideEmailSuggestions();
            }
        });
    </script>

</body>

</html>
