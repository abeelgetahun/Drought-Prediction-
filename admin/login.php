<?php
session_start();
require_once '../config/db.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error_message = "Username and password are required.";
    } else {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = $username;
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $db_username, $hashed_password);
                    if ($stmt->fetch()) {
                        if ($password == $hashed_password) {
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $db_username;
                            header("location: dashboard.php");
                            exit;
                        } else {
                            $error_message = "The password you entered was not valid.";
                        }
                    }
                } else {
                    $error_message = "No account found with that username.";
                }
            } else {
                $error_message = "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        } else {
            $error_message = "Database error: Could not prepare statement.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Drought Prediction System</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
            font-family: 'Open Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 rgba(44,62,80,0.18);
            background: rgba(255,255,255,0.97);
            padding: 2.5rem 2rem 2rem 2rem;
            max-width: 400px;
            width: 100%;
        }
        .login-card .card-header {
            background: none;
            border: none;
            text-align: center;
            padding-bottom: 0;
        }
        .login-logo {
            width: 60px;
            height: 60px;
            margin-bottom: 10px;
        }
        .login-title {
            font-weight: 700;
            color: #2c3e50;
            font-size: 1.6rem;
            margin-bottom: 0.5rem;
        }
        .form-label {
            font-weight: 600;
            color: #2c3e50;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            font-size: 1rem;
        }
        .btn-primary {
            background-color: #3498db;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            transition: background 0.2s;
        }
        .btn-primary:hover {
            background-color: #217dbb;
        }
        .alert {
            border-radius: 8px;
            font-size: 0.97rem;
        }
        @media (max-width: 576px) {
            .login-card {
                padding: 1.5rem 0.5rem 1.5rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-card mx-auto">
        <div class="card-header">
            <img src="../assets/logo.png" alt="Logo" class="login-logo" onerror="this.style.display='none'">
            <div class="login-title">Admin Login</div>
            <div class="text-muted mb-3" style="font-size: 1rem;">Drought Prediction System</div>
        </div>
        <div class="card-body p-0">
            <?php 
            if(!empty($error_message)){
                echo '<div class="alert alert-danger mb-3">' . $error_message . '</div>';
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="username" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary mt-2">Login</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
