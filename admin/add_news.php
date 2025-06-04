<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$page_title = "Add News Article";
$error_message = '';
$success_message = '';

// Define variables and initialize with empty values
$title = $content = $image_url = "";
$title_err = $content_err = "";
$image_upload_err = "";

// Define upload directory and allowed file types/size
define('UPLOAD_DIR_NEWS', '../uploads/images/news/'); // Relative to this admin/add_news.php file
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $final_image_path = null; // This will store the path/URL to be saved in DB

    // Handle file upload
    if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['image_upload']['tmp_name'];
        $file_name = basename($_FILES['image_upload']['name']);
        $file_size = $_FILES['image_upload']['size'];
        $file_type = $_FILES['image_upload']['type'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Validate file size
        if ($file_size > MAX_FILE_SIZE) {
            $image_upload_err = "Error: File size exceeds the limit of 5MB.";
        }
        // Validate file type
        elseif (!in_array($file_type, ALLOWED_TYPES)) {
            $image_upload_err = "Error: Only JPG, PNG, and GIF file types are allowed.";
        } else {
            // Create a unique file name to prevent overwriting
            $unique_file_name = uniqid('', true) . '.' . $file_ext;
            $destination_path = UPLOAD_DIR_NEWS . $unique_file_name;

            // Create upload directory if it doesn't exist
            if (!is_dir(UPLOAD_DIR_NEWS)) {
                if (!mkdir(UPLOAD_DIR_NEWS, 0775, true)) {
                    $image_upload_err = "Error: Failed to create image upload directory.";
                }
            }
            
            if (empty($image_upload_err) && move_uploaded_file($file_tmp_path, $destination_path)) {
                $final_image_path = 'uploads/images/news/' . $unique_file_name; // Path to store in DB (relative to project root)
            } else {
                if(empty($image_upload_err)) $image_upload_err = "Error: Failed to move uploaded file. Check permissions.";
            }
        }
    } elseif (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] != UPLOAD_ERR_NO_FILE) {
        // Handle other upload errors
        $image_upload_err = "Error uploading file. Code: " . $_FILES['image_upload']['error'];
    }

    // If no upload error and no file uploaded, or if upload failed but URL is provided, use URL
    if (empty($final_image_path) && empty($image_upload_err) && !empty(trim($_POST["image_url"]))) {
        $image_url_input = trim($_POST["image_url"]);
        // Basic URL validation (optional, can be more robust)
        if (filter_var($image_url_input, FILTER_VALIDATE_URL)) {
            $final_image_path = $image_url_input;
        } else {
            // If URL is invalid and no file was uploaded successfully, this might be an error or just ignore URL
            // For now, let's assume an invalid URL when provided without a successful upload is an error for image_url field
            // $image_url_err = "Invalid URL provided."; // Or just let $final_image_path remain null
        }
    }
    // If an upload was attempted and failed, but a URL was also provided, we might still want to show the upload error.
    // Current logic: $final_image_path is set by successful upload, else by URL if upload didn't happen or was not attempted.
    // If upload error occurred, $image_upload_err will be shown.

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

    // Image URL is now $final_image_path (could be from upload or URL input)
    // No separate validation for $image_url directly here unless $final_image_path is null and $_POST['image_url'] was invalid.

    // Check input errors before inserting in database
    if (empty($title_err) && empty($content_err) && empty($image_upload_err)) { // Added $image_upload_err check
        $sql = "INSERT INTO news (title, content, image_url) VALUES (?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("sss", $param_title, $param_content, $param_image_path);

            $param_title = $title;
            $param_content = $content;
            $param_image_path = $final_image_path; // Use the determined path

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "News article added successfully!";
                header("location: manage_news.php");
                exit();
            } else {
                $error_message = "Something went wrong. Please try again later. Error: " . $mysqli->error;
            }
            $stmt->close();
        } else {
             $error_message = "Database error: Could not prepare statement. " . $mysqli->error;
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
                        <h2 class="section-heading mb-4"><i class="fas fa-plus me-2"></i><?php echo $page_title; ?></h2>

                        <?php 
                        if(!empty($error_message)){
                            echo '<div class="alert alert-danger mb-3">' . $error_message . '</div>';
                        }
                        if(!empty($image_upload_err)){
                            echo '<div class="alert alert-danger mb-3">' . $image_upload_err . '</div>';
                        }
                        ?>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
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
                            <p class="text-muted"><small>Upload a new image or provide an image URL. If both are provided, the uploaded image will be used.</small></p>

                            <div class="mb-3">
                                <label for="image_upload" class="form-label">Upload New Image (Optional)</label>
                                <input type="file" class="form-control" id="image_upload" name="image_upload">
                            </div>

                            <div class="mb-3">
                                <label for="image_url" class="form-label">Or Image URL (Optional)</label>
                                <input type="text" name="image_url" class="form-control" id="image_url" value="<?php echo htmlspecialchars($image_url); ?>">
                            </div>
                            <hr>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Add News</button>
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
