<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Hash Generator</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Password Hash Generator</h2>
        <form method="post">
            <div class="mb-3">
                <label for="password" class="form-label">Enter Password:</label>
                <input type="text" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Generate Hash</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $password = $_POST['password'];
            if (!empty($password)) {
                // Generate the hash
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                echo "<div class='mt-4 alert alert-success'>";
                echo "<strong>Original Password:</strong> " . htmlspecialchars($password) . "<br>";
                echo "<strong>Hashed Password:</strong> " . htmlspecialchars($hashed_password);
                echo "</div>";
                echo "<p class='mt-2'>Store this hashed password in the 'users' table for the admin user.</p>";
            } else {
                echo "<div class='mt-4 alert alert-warning'>Please enter a password.</div>";
            }
        }
        ?>
    </div>
</body>
</html>
