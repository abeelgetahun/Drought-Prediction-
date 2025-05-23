<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$page_title = "Edit Focus Category";
$error_message = '';
$success_message = '';

// Define variables
$name = $description = "";
$name_err = $description_err = "";
$focus_id = null;

// Check if ID is provided for editing
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $focus_id = trim($_GET["id"]);

    $sql_fetch = "SELECT name, description FROM focus WHERE id = ?";
    if ($stmt_fetch = $mysqli->prepare($sql_fetch)) {
        $stmt_fetch->bind_param("i", $focus_id);
        if ($stmt_fetch->execute()) {
            $stmt_fetch->store_result();
            if ($stmt_fetch->num_rows == 1) {
                $stmt_fetch->bind_result($name, $description);
                $stmt_fetch->fetch();
            } else {
                $_SESSION['error_message'] = "Focus category not found.";
                header("location: manage_focus.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Error fetching focus category: " . $mysqli->error;
            header("location: manage_focus.php");
            exit();
        }
        $stmt_fetch->close();
    } else {
        $_SESSION['error_message'] = "Error preparing fetch statement: " . $mysqli->error;
        header("location: manage_focus.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "No focus category ID specified for editing.";
    header("location: manage_focus.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["id"])){
        $error_message = "Focus category ID is missing from the form submission.";
    } else {
        $focus_id = $_POST["id"];
    }

    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter the category name.";
    } else {
        // Check if name already exists for a *different* ID
        $sql_check = "SELECT id FROM focus WHERE name = ? AND id != ?";
        if($stmt_check = $mysqli->prepare($sql_check)){
            $stmt_check->bind_param("si", $param_name_check, $param_id_check);
            $param_name_check = trim($_POST["name"]);
            $param_id_check = $focus_id;
            if($stmt_check->execute()){
                $stmt_check->store_result();
                if($stmt_check->num_rows > 0){
                    $name_err = "This focus category name already exists.";
                } else {
                    $name = trim($_POST["name"]);
                }
            } else {
                $error_message = "Oops! Something went wrong checking name. Please try again later.";
            }
            $stmt_check->close();
        } else {
             $error_message = "Database error: Could not prepare name check statement.";
        }
    }
    
    // Validate description
    if (empty(trim($_POST["description"]))) {
        $description_err = "Please enter the description.";
    } else {
        $description = trim($_POST["description"]);
    }

    if (empty($name_err) && empty($description_err) && !empty($focus_id) && empty($error_message)) {
        $sql_update = "UPDATE focus SET name = ?, description = ? WHERE id = ?";

        if ($stmt_update = $mysqli->prepare($sql_update)) {
            $stmt_update->bind_param("ssi", $param_name, $param_description, $param_id);

            $param_name = $name;
            $param_description = $description;
            $param_id = $focus_id;

            if ($stmt_update->execute()) {
                $_SESSION['success_message'] = "Focus category updated successfully!";
                header("location: manage_focus.php");
                exit();
            } else {
                $error_message = "Something went wrong. Please try again later. Error: " . $mysqli->error;
            }
            $stmt_update->close();
        } else {
             $error_message = "Database error: Could not prepare update statement. " . $mysqli->error;
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

        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $focus_id; ?>"/>
            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" id="name" value="<?php echo htmlspecialchars($name); ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>" id="description" rows="3"><?php echo htmlspecialchars($description); ?></textarea>
                <span class="invalid-feedback"><?php echo $description_err; ?></span>
            </div>
            <button type="submit" class="btn btn-primary">Update Focus Category</button>
            <a href="manage_focus.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <?php require_once 'includes/admin_footer.php'; ?>
</body>
</html>
