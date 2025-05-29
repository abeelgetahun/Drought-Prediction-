<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$page_title = "Add Event";
$error_message = '';
$success_message = '';

// Define variables and initialize
$name = $event_date_str = $location = $description = "";
$name_err = $event_date_err = $location_err = $description_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter the event name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate event_date
    if (empty(trim($_POST["event_date"]))) {
        $event_date_err = "Please enter the event date.";
    } else {
        $event_date_str = trim($_POST["event_date"]);
        // Basic validation for datetime format (YYYY-MM-DDTHH:MM)
        if (!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $event_date_str)) {
            $event_date_err = "Invalid date format. Use YYYY-MM-DDTHH:MM.";
        } else {
            // Convert to MySQL DATETIME format
            try {
                $dt = new DateTime($event_date_str);
                $event_date = $dt->format('Y-m-d H:i:s');
            } catch (Exception $e) {
                $event_date_err = "Invalid date value.";
            }
        }
    }

    // Validate location
    if (empty(trim($_POST["location"]))) {
        $location_err = "Please enter the event location.";
    } else {
        $location = trim($_POST["location"]);
    }

    // Validate description
    if (empty(trim($_POST["description"]))) {
        $description_err = "Please enter the event description.";
    } else {
        $description = trim($_POST["description"]);
    }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($event_date_err) && empty($location_err) && empty($description_err)) {
        $sql = "INSERT INTO events (name, event_date, location, description) VALUES (?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ssss", $param_name, $param_event_date, $param_location, $param_description);

            $param_name = $name;
            $param_event_date = $event_date; // Use the formatted date
            $param_location = $location;
            $param_description = $description;

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Event added successfully!";
                header("location: manage_events.php");
                exit();
            } else {
                $error_message = "Something went wrong. Please try again later. Error: " . $mysqli->error;
            }
            $stmt->close();
        } else {
             $error_message = "Database error: Could not prepare statement. " . $mysqli->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php require_once 'includes/admin_navbar.php'; ?>

    <div class="container mt-5 pt-5 mb-5">
        <h2><?php echo $page_title; ?></h2>

        <?php 
        if(!empty($error_message)){
            echo '<div class="alert alert-danger">' . $error_message . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Event Name</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" id="name" value="<?php echo htmlspecialchars($name); ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>
            <div class="mb-3">
                <label for="event_date" class="form-label">Event Date and Time</label>
                <input type="datetime-local" name="event_date" class="form-control <?php echo (!empty($event_date_err)) ? 'is-invalid' : ''; ?>" id="event_date" value="<?php echo htmlspecialchars($event_date_str); ?>">
                <span class="invalid-feedback"><?php echo $event_date_err; ?></span>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" class="form-control <?php echo (!empty($location_err)) ? 'is-invalid' : ''; ?>" id="location" value="<?php echo htmlspecialchars($location); ?>">
                <span class="invalid-feedback"><?php echo $location_err; ?></span>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>" id="description" rows="5"><?php echo htmlspecialchars($description); ?></textarea>
                <span class="invalid-feedback"><?php echo $description_err; ?></span>
            </div>
            <button type="submit" class="btn btn-primary">Add Event</button>
            <a href="manage_events.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <?php require_once 'includes/admin_footer.php'; ?>
</body>
</html>
