<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SecureGate - Visitor Management System</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f5f1ff 0%, #e8e0ff 100%);
            padding: 20px;
        }

        .container {
            text-align: center;
            max-width: 900px;
            width: 100%;
        }

        .brand {
            margin-bottom: 20px;
        }

        .brand-icon {
            font-size: 56px;
        }

        h1 {
            font-size: 36px;
            color: #3d2b8f;
            margin-bottom: 8px;
        }

        .tagline {
            color: #777d91;
            margin-bottom: 48px;
        }

        .cards {
            display: flex;
            gap: 32px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            padding: 48px 40px;
            width: 320px;
            box-shadow: 0 10px 30px rgba(61, 43, 143, 0.12);
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(61, 43, 143, 0.2);
        }

        .card-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .card h2 {
            font-size: 22px;
            color: #3d2b8f;
            margin-bottom: 10px;
        }

        .card p {
            color: #777d91;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .card .btn {
            display: inline-block;
            background: #6c4df6;
            color: #fff;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
        }

        .card.client .btn {
            background: #24b47e;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="brand">
            <div class="brand-icon">🛡️</div>
            <h1>SecureGate</h1>
            <p class="tagline">Visitor Management System</p>
        </div>

        <div class="cards">

            <a href="client/" class="card client">
                <div class="card-icon">🧑</div>
                <h2>I'm a Visitor</h2>
                <p>Register your visit by filling in the visitor form. No account needed.</p>
                <span class="btn">Register Visit</span>
            </a>

            <a href="frontend/login.php" class="card">
                <div class="card-icon">🔐</div>
                <h2>I'm an Admin</h2>
                <p>Sign in to manage visitors, departments and reports.</p>
                <span class="btn">Admin Login</span>
            </a>

        </div>

    </div>

</body>

</html>
