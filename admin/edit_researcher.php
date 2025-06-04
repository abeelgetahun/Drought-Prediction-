<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$page_title = "Edit Researcher";
$error_message = '';
$success_message = '';

// Define variables
$name = $bio = $photo_url = $research_focus = ""; // $photo_url will hold existing
$name_err = $bio_err = $research_focus_err = "";
$photo_upload_err = ""; // For new photo upload errors
$researcher_id = null;

// Constants for upload, ensure they are available or redefine
if (!defined('UPLOAD_DIR_RESEARCHERS')) {
    define('UPLOAD_DIR_RESEARCHERS', '../uploads/images/researchers/');
}
if (!defined('ALLOWED_TYPES')) {
    define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
}
if (!defined('MAX_FILE_SIZE')) {
    define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
}


// Check if ID is provided for editing
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $researcher_id = trim($_GET["id"]);

    $sql_fetch = "SELECT name, bio, photo_url, research_focus FROM researchers WHERE id = ?";
    if ($stmt_fetch = $mysqli->prepare($sql_fetch)) {
        $stmt_fetch->bind_param("i", $researcher_id);
        if ($stmt_fetch->execute()) {
            $stmt_fetch->store_result();
            if ($stmt_fetch->num_rows == 1) {
                $stmt_fetch->bind_result($name, $bio, $photo_url, $research_focus); // $photo_url gets current db value
                $stmt_fetch->fetch();
            } else {
                $_SESSION['error_message'] = "Researcher not found.";
                header("location: manage_researchers.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Error fetching researcher: " . $mysqli->error;
            header("location: manage_researchers.php");
            exit();
        }
        $stmt_fetch->close();
    } else {
        $_SESSION['error_message'] = "Error preparing fetch statement: " . $mysqli->error;
        header("location: manage_researchers.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "No researcher ID specified for editing.";
    header("location: manage_researchers.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["id"])){
        $error_message = "Researcher ID is missing from the form submission.";
    } else {
        $researcher_id = $_POST["id"];
    }

    $current_photo_db_path = $photo_url; // Preserve existing photo path from DB
    $final_photo_path = $current_photo_db_path; // Initialize

    // Handle new file upload for photo
    if (isset($_FILES['photo_upload']) && $_FILES['photo_upload']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['photo_upload']['tmp_name'];
        $file_name = basename($_FILES['photo_upload']['name']);
        $file_size = $_FILES['photo_upload']['size'];
        $file_type = $_FILES['photo_upload']['type'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if ($file_size > MAX_FILE_SIZE) {
            $photo_upload_err = "Error: Photo file size exceeds 5MB.";
        } elseif (!in_array($file_type, ALLOWED_TYPES)) {
            $photo_upload_err = "Error: Only JPG, PNG, GIF allowed for photos.";
        } else {
            $unique_file_name = uniqid('researcher_', true) . '.' . $file_ext;
            $destination_path = UPLOAD_DIR_RESEARCHERS . $unique_file_name;
            if (!is_dir(UPLOAD_DIR_RESEARCHERS)) {
                if (!mkdir(UPLOAD_DIR_RESEARCHERS, 0775, true)) {
                    $photo_upload_err = "Error: Failed to create photo upload directory.";
                }
            }
            if (empty($photo_upload_err) && move_uploaded_file($file_tmp_path, $destination_path)) {
                $final_photo_path = 'uploads/images/researchers/' . $unique_file_name;
                // Delete old local photo if it existed and wasn't a URL
                if (!empty($current_photo_db_path) && !preg_match('/^http(s)?:\/\//', $current_photo_db_path)) {
                    if (file_exists('../' . $current_photo_db_path)) {
                        unlink('../' . $current_photo_db_path);
                    }
                }
            } else {
                if(empty($photo_upload_err)) $photo_upload_err = "Error: Failed to move uploaded photo.";
            }
        }
    } elseif (isset($_FILES['photo_upload']) && $_FILES['photo_upload']['error'] != UPLOAD_ERR_NO_FILE) {
        $photo_upload_err = "Error uploading photo. Code: " . $_FILES['photo_upload']['error'];
    }

    // If no new file was successfully uploaded, consider the photo_url from the form
    if (!(isset($_FILES['photo_upload']) && $_FILES['photo_upload']['error'] == UPLOAD_ERR_OK && empty($photo_upload_err))) {
        $photo_url_from_form = trim($_POST["photo_url"]);
        if ($photo_url_from_form !== $current_photo_db_path) { // URL field changed
            if (empty($photo_url_from_form)) { // URL field cleared
                $final_photo_path = null;
                if (!empty($current_photo_db_path) && !preg_match('/^http(s)?:\/\//', $current_photo_db_path)) {
                    if (file_exists('../' . $current_photo_db_path)) {
                        unlink('../' . $current_photo_db_path);
                    }
                }
            } elseif (filter_var($photo_url_from_form, FILTER_VALIDATE_URL)) {
                $final_photo_path = $photo_url_from_form; // Use new URL
                if (!empty($current_photo_db_path) && !preg_match('/^http(s)?:\/\//', $current_photo_db_path)) {
                     if (file_exists('../' . $current_photo_db_path)) {
                        unlink('../' . $current_photo_db_path);
                    }
                }
            } else {
                // Invalid URL, do nothing to $final_photo_path or set specific error
            }
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

    // $final_photo_path is for DB
    if (empty($name_err) && empty($bio_err) && empty($research_focus_err) && empty($photo_upload_err) && !empty($researcher_id)) {
        $sql_update = "UPDATE researchers SET name = ?, bio = ?, photo_url = ?, research_focus = ? WHERE id = ?";

        if ($stmt_update = $mysqli->prepare($sql_update)) {
            $stmt_update->bind_param("ssssi", $param_name, $param_bio, $param_final_photo_path, $param_research_focus, $param_id);

            $param_name = $name;
            $param_bio = $bio;
            $param_final_photo_path = $final_photo_path; // Use determined path
            $param_research_focus = $research_focus;
            $param_id = $researcher_id;

            if ($stmt_update->execute()) {
                $_SESSION['success_message'] = "Researcher updated successfully!";
                header("location: manage_researchers.php");
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
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
        }
        body {
            background-color: #f5f8fa;
            font-family: 'Open Sans', sans-serif;
            min-height: 100vh;
        }
        .section-heading {
            font-weight: 700;
            color: var(--dark-color);
            border-bottom: 2px solid var(--secondary-color);
            padding-bottom: 10px;
            margin-bottom: 30px;
            display: inline-block;
        }
        .card {
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(44,62,80,0.08);
            border: none;
            background: #fff;
        }
        .card-body {
            padding: 2rem 2rem 1.5rem 2rem;
        }
        .form-label {
            font-weight: 600;
            color: var(--primary-color);
        }
        .form-control, textarea.form-control {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            font-size: 1rem;
        }
        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 2px rgba(52,152,219,0.15);
        }
        .btn-primary {
            background-color: var(--secondary-color);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            transition: background 0.2s;
        }
        .btn-primary:hover {
            background-color: #217dbb;
        }
        .btn-secondary {
            border-radius: 8px;
            font-weight: 600;
        }
        .alert {
            border-radius: 8px;
            font-size: 0.97rem;
        }
        .current-image-preview {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            max-width: 200px;
            margin-bottom: 10px;
            box-shadow: 0 2px 8px rgba(44,62,80,0.07);
        }
        @media (max-width: 576px) {
            .card-body {
                padding: 1rem 0.5rem 1rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <?php require_once 'includes/admin_navbar.php'; ?>

    <div class="container mt-5 pt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card">
                    <div class="card-body">
                        <h2 class="section-heading mb-4"><i class="fas fa-user-edit me-2"></i><?php echo $page_title; ?></h2>

                        <?php 
                        if(!empty($error_message)){
                            echo '<div class="alert alert-danger mb-3">' . $error_message . '</div>';
                        }
                        if(!empty($photo_upload_err)){
                            echo '<div class="alert alert-danger mb-3">' . $photo_upload_err . '</div>';
                        }
                        ?>

                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                            <input type="hidden" name="id" value="<?php echo $researcher_id; ?>"/>
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
                            <p class="text-muted"><small>Upload a new photo or provide/update the photo URL. If a new photo is uploaded, it will replace any existing photo or URL.</small></p>

                            <?php if (!empty($photo_url)): ?>
                            <div class="mb-3">
                                <label class="form-label">Current Photo:</label><br>
                                <img src="<?php echo (preg_match('/^http(s)?:\/\//', $photo_url) ? htmlspecialchars($photo_url) : '../' . htmlspecialchars($photo_url)); ?>" alt="Current Researcher Photo" class="current-image-preview">
                            </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="photo_upload" class="form-label">Upload New Photo to Replace (Optional)</label>
                                <input type="file" class="form-control" id="photo_upload" name="photo_upload">
                            </div>

                            <div class="mb-3">
                                <label for="photo_url" class="form-label">Or Update Photo URL (Optional)</label>
                                <input type="text" name="photo_url" class="form-control" id="photo_url" value="<?php echo htmlspecialchars($photo_url); ?>">
                                <small class="form-text text-muted">If providing a URL, ensure it's a direct link to an image. If uploading, this URL will be ignored or replaced.</small>
                            </div>
                            <hr>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Update Researcher</button>
                                <a href="manage_researchers.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div
