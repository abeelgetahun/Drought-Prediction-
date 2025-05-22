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
$photo_upload_err = "";

// Define upload directory and allowed file types/size for researchers
define('UPLOAD_DIR_RESEARCHERS', '../uploads/images/researchers/'); // Relative to this admin/add_researcher.php file
// Re-using ALLOWED_TYPES and MAX_FILE_SIZE if defined, or define them if not (e.g. if this file could be run standalone)
if (!defined('ALLOWED_TYPES')) {
    define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
}
if (!defined('MAX_FILE_SIZE')) {
    define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $final_photo_path = null; // This will store the path/URL to be saved in DB

    // Handle file upload for photo
    if (isset($_FILES['photo_upload']) && $_FILES['photo_upload']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['photo_upload']['tmp_name'];
        $file_name = basename($_FILES['photo_upload']['name']);
        $file_size = $_FILES['photo_upload']['size'];
        $file_type = $_FILES['photo_upload']['type'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if ($file_size > MAX_FILE_SIZE) {
            $photo_upload_err = "Error: Photo file size exceeds the limit of 5MB.";
        } elseif (!in_array($file_type, ALLOWED_TYPES)) {
            $photo_upload_err = "Error: Only JPG, PNG, and GIF file types are allowed for photos.";
        } else {
            $unique_file_name = uniqid('researcher_', true) . '.' . $file_ext;
            $destination_path = UPLOAD_DIR_RESEARCHERS . $unique_file_name;

            if (!is_dir(UPLOAD_DIR_RESEARCHERS)) {
                if (!mkdir(UPLOAD_DIR_RESEARCHERS, 0775, true)) {
                    $photo_upload_err = "Error: Failed to create photo upload directory.";
                }
            }
            
            if (empty($photo_upload_err) && move_uploaded_file($file_tmp_path, $destination_path)) {
                $final_photo_path = 'uploads/images/researchers/' . $unique_file_name; // Path for DB
            } else {
                if(empty($photo_upload_err)) $photo_upload_err = "Error: Failed to move uploaded photo. Check permissions.";
            }
        }
    } elseif (isset($_FILES['photo_upload']) && $_FILES['photo_upload']['error'] != UPLOAD_ERR_NO_FILE) {
        $photo_upload_err = "Error uploading photo. Code: " . $_FILES['photo_upload']['error'];
    }

    if (empty($final_photo_path) && empty($photo_upload_err) && !empty(trim($_POST["photo_url"]))) {
        $photo_url_input = trim($_POST["photo_url"]);
        if (filter_var($photo_url_input, FILTER_VALIDATE_URL)) {
            $final_photo_path = $photo_url_input;
        } else {
            // $photo_url_err = "Invalid Photo URL provided."; // Optional: error for invalid URL
        }
    }
    $photo_url = trim($_POST["photo_url"]); // For form repopulation

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

    // Photo URL is now $final_photo_path

    // Check input errors before inserting in database
    if (empty($name_err) && empty($bio_err) && empty($research_focus_err) && empty($photo_upload_err)) {
        $sql = "INSERT INTO researchers (name, bio, photo_url, research_focus) VALUES (?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ssss", $param_name, $param_bio, $param_final_photo_path, $param_research_focus);

            $param_name = $name;
            $param_bio = $bio;
            $param_final_photo_path = $final_photo_path; // Use the determined path
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
        if(!empty($photo_upload_err)){ // Display photo upload specific errors
            echo '<div class="alert alert-danger">' . $photo_upload_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
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

            <hr>
            <p class="text-muted"><small>Upload a new photo or provide a photo URL. If both are provided, the uploaded photo will be used.</small></p>

            <div class="mb-3">
                <label for="photo_upload" class="form-label">Upload New Photo (Optional)</label>
                <input type="file" class="form-control" id="photo_upload" name="photo_upload">
            </div>

            <div class="mb-3">
                <label for="photo_url" class="form-label">Or Photo URL (Optional)</label>
                <input type="text" name="photo_url" class="form-control" id="photo_url" value="<?php echo htmlspecialchars($photo_url); ?>">
            </div>
            <hr>

            <button type="submit" class="btn btn-primary">Add Researcher</button>
            <a href="manage_researchers.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <?php require_once 'includes/admin_footer.php'; ?>
</body>
</html>
