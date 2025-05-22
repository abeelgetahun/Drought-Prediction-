<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$page_title = "Add Researcher";
$error_message = '';
$success_message = '';

// Define variables and initialize
$name = $bio = $photo_url = $research_focus = "";
$name_err = $bio_err = $research_focus_err = ""; // photo_url is optional

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter the researcher's name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate bio
    if (empty(trim($_POST["bio"]))) {
        $bio_err = "Please enter the researcher's biography.";
    } else {
        $bio = trim($_POST["bio"]);
    }
    
    // Validate research_focus
    if (empty(trim($_POST["research_focus"]))) {
        $research_focus_err = "Please enter the research focus.";
    } else {
        $research_focus = trim($_POST["research_focus"]);
    }

    // Photo URL is optional
    $photo_url = trim($_POST["photo_url"]);

    // Check input errors before inserting in database
    if (empty($name_err) && empty($bio_err) && empty($research_focus_err)) {
        $sql = "INSERT INTO researchers (name, bio, photo_url, research_focus) VALUES (?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ssss", $param_name, $param_bio, $param_photo_url, $param_research_focus);

            $param_name = $name;
            $param_bio = $bio;
            $param_photo_url = $photo_url;
            $param_research_focus = $research_focus;

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Researcher added successfully!";
                header("location: manage_researchers.php");
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
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" id="name" value="<?php echo htmlspecialchars($name); ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>
            <div class="mb-3">
                <label for="bio" class="form-label">Biography</label>
                <textarea name="bio" class="form-control <?php echo (!empty($bio_err)) ? 'is-invalid' : ''; ?>" id="bio" rows="5"><?php echo htmlspecialchars($bio); ?></textarea>
                <span class="invalid-feedback"><?php echo $bio_err; ?></span>
            </div>
            <div class="mb-3">
                <label for="research_focus" class="form-label">Research Focus</label>
                <input type="text" name="research_focus" class="form-control <?php echo (!empty($research_focus_err)) ? 'is-invalid' : ''; ?>" id="research_focus" value="<?php echo htmlspecialchars($research_focus); ?>">
                <span class="invalid-feedback"><?php echo $research_focus_err; ?></span>
            </div>
            <div class="mb-3">
                <label for="photo_url" class="form-label">Photo URL (Optional)</label>
                <input type="text" name="photo_url" class="form-control" id="photo_url" value="<?php echo htmlspecialchars($photo_url); ?>">
                <small class="form-text text-muted">Enter a URL for the researcher's photo.</small>
            </div>
            <button type="submit" class="btn btn-primary">Add Researcher</button>
            <a href="manage_researchers.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <?php require_once 'includes/admin_footer.php'; ?>
</body>
</html>
