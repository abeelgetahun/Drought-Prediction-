<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$page_title = "Edit News Article";
$error_message = '';
$success_message = '';

// Define variables and initialize with empty values
$title = $content = $image_url = ""; // $image_url will hold the existing value
$title_err = $content_err = "";
$image_upload_err = ""; // For new image upload errors
$news_id = null;

// Constants from add_news.php, ensure they are available or redefine
if (!defined('UPLOAD_DIR_NEWS')) {
    define('UPLOAD_DIR_NEWS', '../uploads/images/news/');
}
if (!defined('ALLOWED_TYPES')) {
    define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
}
if (!defined('MAX_FILE_SIZE')) {
    define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
}

// Check if ID is provided for editing
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $news_id = trim($_GET["id"]);

    // Fetch the news article to pre-fill the form
    $sql_fetch = "SELECT title, content, image_url FROM news WHERE id = ?";
    if ($stmt_fetch = $mysqli->prepare($sql_fetch)) {
        $stmt_fetch->bind_param("i", $news_id);
        if ($stmt_fetch->execute()) {
            $stmt_fetch->store_result();
            if ($stmt_fetch->num_rows == 1) {
                $stmt_fetch->bind_result($title, $content, $image_url); // $image_url gets current db value
                $stmt_fetch->fetch();
            } else {
                $_SESSION['error_message'] = "News article not found.";
                header("location: manage_news.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Error fetching news article: " . $mysqli->error;
            header("location: manage_news.php");
            exit();
        }
        $stmt_fetch->close();
    } else {
        $_SESSION['error_message'] = "Error preparing fetch statement: " . $mysqli->error;
        header("location: manage_news.php");
        exit();
    }
} else {
    // If no ID is provided, redirect
    $_SESSION['error_message'] = "No news article ID specified for editing.";
    header("location: manage_news.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure news_id is present in POST if form is submitted (hidden field)
    if(empty($_POST["id"])){
        $error_message = "News ID is missing from the form submission."; // Should not happen with hidden field
    } else {
        $news_id = $_POST["id"]; // Get ID from hidden input
    }
    
    $current_image_db_path = $image_url; // Preserve the existing image path from DB for potential deletion
    $final_image_path = $current_image_db_path; // Initialize with existing path

    // Handle new file upload
    if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['image_upload']['tmp_name'];
        $file_name = basename($_FILES['image_upload']['name']);
        $file_size = $_FILES['image_upload']['size'];
        $file_type = $_FILES['image_upload']['type'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if ($file_size > MAX_FILE_SIZE) {
            $image_upload_err = "Error: File size exceeds the limit of 5MB.";
        } elseif (!in_array($file_type, ALLOWED_TYPES)) {
            $image_upload_err = "Error: Only JPG, PNG, and GIF file types are allowed.";
        } else {
            $unique_file_name = uniqid('', true) . '.' . $file_ext;
            $destination_path = UPLOAD_DIR_NEWS . $unique_file_name;
            if (!is_dir(UPLOAD_DIR_NEWS)) {
                if (!mkdir(UPLOAD_DIR_NEWS, 0775, true)) {
                    $image_upload_err = "Error: Failed to create image upload directory.";
                }
            }
            if (empty($image_upload_err) && move_uploaded_file($file_tmp_path, $destination_path)) {
                $final_image_path = 'uploads/images/news/' . $unique_file_name; // New image path
                // If there was an old local image, try to delete it
                if (!empty($current_image_db_path) && !preg_match('/^http(s)?:\/\//', $current_image_db_path)) {
                    if (file_exists('../' . $current_image_db_path)) { // Check from project root
                        unlink('../' . $current_image_db_path); // Attempt to delete
                    }
                }
            } else {
                 if(empty($image_upload_err)) $image_upload_err = "Error: Failed to move uploaded file.";
            }
        }
    } elseif (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] != UPLOAD_ERR_NO_FILE) {
        $image_upload_err = "Error uploading file. Code: " . $_FILES['image_upload']['error'];
    }

    // If no new file was uploaded (or upload failed but error not critical yet), check image_url input
    // $final_image_path is already $current_image_db_path or new uploaded path
    // If a new file was NOT successfully uploaded, then consider the image_url from the form
    if (!(isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] == UPLOAD_ERR_OK && empty($image_upload_err))) {
        $image_url_from_form = trim($_POST["image_url"]);
        if ($image_url_from_form !== $current_image_db_path) { // URL field was changed
            if (empty($image_url_from_form)) { // URL field was cleared
                $final_image_path = null; // Set to null or empty string
                // Delete old local image if it existed and wasn't a URL
                if (!empty($current_image_db_path) && !preg_match('/^http(s)?:\/\//', $current_image_db_path)) {
                     if (file_exists('../' . $current_image_db_path)) {
                        unlink('../' . $current_image_db_path);
                    }
                }
            } elseif (filter_var($image_url_from_form, FILTER_VALIDATE_URL)) {
                $final_image_path = $image_url_from_form; // Use new URL
                 // Delete old local image if it existed and wasn't a URL
                if (!empty($current_image_db_path) && !preg_match('/^http(s)?:\/\//', $current_image_db_path)) {
                     if (file_exists('../' . $current_image_db_path)) {
                        unlink('../' . $current_image_db_path);
                    }
                }
            } else {
                // Invalid URL provided in the image_url field, and no new image uploaded
                // Keep $final_image_path as $current_image_db_path if $image_url_from_form is invalid and was not empty
                // Or set an error for image_url field: $image_url_err = "Invalid URL provided";
                // For now, if it's not a valid URL and not empty, we will just keep the old image or the newly uploaded one if any.
                // If $image_url_from_form is not empty and not a valid URL, this is a bit ambiguous.
                // Let's assume if it's not empty and not valid, we will actually reflect this as an error or clear it.
                // For simplicity, if it's not empty and not valid, we will not change $final_image_path from what it was (either uploaded path or original db path)
                // $image_url = $image_url_from_form; // Keep the invalid value in the form field for user to see
            }
        }
        // If $image_url_from_form is same as $current_image_db_path, $final_image_path is already correctly set.
    }
     // At this point, $final_image_path holds the path to be saved.
     // $image_url will be used to re-populate the form field if there's an error.
    $image_url = trim($_POST["image_url"]); // This is for repopulating the form field

    // Validate title
    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter a title.";
    } else {
        $title = trim($_POST["title"]);
    }

    // Validate content
    if (empty(trim($_POST["content"]))) {
        $content_err = "Please enter the content.";
    } else {
        $content = trim($_POST["content"]);
    }

    // Check input errors before updating in database
    // $image_url is for form repopulation, $final_image_path is for DB
    if (empty($title_err) && empty($content_err) && empty($image_upload_err) && !empty($news_id)) {
        $sql_update = "UPDATE news SET title = ?, content = ?, image_url = ? WHERE id = ?";

        if ($stmt_update = $mysqli->prepare($sql_update)) {
            $stmt_update->bind_param("sssi", $param_title, $param_content, $param_final_image_path, $param_id);

            $param_title = $title;
            $param_content = $content;
            $param_final_image_path = $final_image_path; // Use the determined path
            $param_id = $news_id;

            if ($stmt_update->execute()) {
                $_SESSION['success_message'] = "News article updated successfully!";
                header("location: manage_news.php");
                exit();
            } else {
                $error_message = "Something went wrong. Please try again later. Error: " . $mysqli->error;
            }
            $stmt_update->close();
        } else {
             $error_message = "Database error: Could not prepare update statement. " . $mysqli->error;
        }
    }
    // $mysqli->close(); // Connection will be closed by PHP or by the footer include
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
            max-width: 220px;
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
                        <h2 class="section-heading mb-4"><i class="fas fa-edit me-2"></i><?php echo $page_title; ?></h2>

                        <?php 
                        if(!empty($error_message)){
                            echo '<div class="alert alert-danger mb-3">' . $error_message . '</div>';
                        }
                        if(!empty($image_upload_err)){
                            echo '<div class="alert alert-danger mb-3">' . $image_upload_err . '</div>';
                        }
                        ?>

                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                            <input type="hidden" name="id" value="<?php echo $news_id; ?>"/>
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" id="title" value="<?php echo htmlspecialchars($title); ?>">
                                <span class="invalid-feedback"><?php echo $title_err; ?></span>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea name="content" class="form-control <?php echo (!empty($content_err)) ? 'is-invalid' : ''; ?>" id="content" rows="6"><?php echo htmlspecialchars($content); ?></textarea>
                                <span class="invalid-feedback"><?php echo $content_err; ?></span>
                            </div>

                            <hr>
                            <p class="text-muted"><small>Upload a new image or provide/update the image URL. If a new image is uploaded, it will replace any existing image or URL.</small></p>

                            <?php if (!empty($image_url)): ?>
                            <div class="mb-3">
                                <label class="form-label">Current Image:</label><br>
                                <img src="<?php echo (preg_match('/^http(s)?:\/\//', $image_url) ? htmlspecialchars($image_url) : '../' . htmlspecialchars($image_url)); ?>" alt="Current News Image" class="current-image-preview">
                            </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="image_upload" class="form-label">Upload New Image to Replace (Optional)</label>
                                <input type="file" class="form-control" id="image_upload" name="image_upload">
                            </div>

                            <div class="mb-3">
                                <label for="image_url" class="form-label">Or Update Image URL (Optional)</label>
                                <input type="text" name="image_url" class="form-control" id="image_url" value="<?php echo htmlspecialchars($image_url); ?>">
                                <small class="form-text text-muted">If providing a URL, ensure it's a direct link to an image. If uploading, this URL will be ignored or replaced.</small>
                            </div>
                            <hr>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Update News</button>
                                <a href="manage_news.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'includes/admin_footer.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
