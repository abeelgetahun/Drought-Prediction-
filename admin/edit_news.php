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
$title = $content = $image_url = "";
$title_err = $content_err = "";
$news_id = null;

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
                $stmt_fetch->bind_result($title, $content, $image_url);
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
        $error_message = "News ID is missing from the form submission.";
    } else {
        $news_id = $_POST["id"]; // Get ID from hidden input
    }

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

    // Image URL is optional
    $image_url = trim($_POST["image_url"]);

    // Check input errors before updating in database
    if (empty($title_err) && empty($content_err) && !empty($news_id)) {
        $sql_update = "UPDATE news SET title = ?, content = ?, image_url = ? WHERE id = ?";

        if ($stmt_update = $mysqli->prepare($sql_update)) {
            $stmt_update->bind_param("sssi", $param_title, $param_content, $param_image_url, $param_id);

            $param_title = $title;
            $param_content = $content;
            $param_image_url = $image_url;
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
            <input type="hidden" name="id" value="<?php echo $news_id; ?>"/>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" id="title" value="<?php echo htmlspecialchars($title); ?>">
                <span class="invalid-feedback"><?php echo $title_err; ?></span>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" class="form-control <?php echo (!empty($content_err)) ? 'is-invalid' : ''; ?>" id="content" rows="5"><?php echo htmlspecialchars($content); ?></textarea>
                <span class="invalid-feedback"><?php echo $content_err; ?></span>
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">Image URL (Optional)</label>
                <input type="text" name="image_url" class="form-control" id="image_url" value="<?php echo htmlspecialchars($image_url); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update News</button>
            <a href="manage_news.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <?php require_once 'includes/admin_footer.php'; ?>
</body>
</html>
