<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$page_title = "Add Story";
$error_message = '';
$success_message = '';

// Define variables and initialize
$title = $author = $narrative = "";
$title_err = $author_err = $narrative_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate title
    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter the story title.";
    } else {
        $title = trim($_POST["title"]);
    }

    // Validate author
    if (empty(trim($_POST["author"]))) {
        $author_err = "Please enter the author's name.";
    } else {
        $author = trim($_POST["author"]);
    }
    
    // Validate narrative
    if (empty(trim($_POST["narrative"]))) {
        $narrative_err = "Please enter the narrative.";
    } else {
        $narrative = trim($_POST["narrative"]);
    }

    // Check input errors before inserting in database
    if (empty($title_err) && empty($author_err) && empty($narrative_err)) {
        $sql = "INSERT INTO stories (title, author, narrative) VALUES (?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("sss", $param_title, $param_author, $param_narrative);

            $param_title = $title;
            $param_author = $author;
            $param_narrative = $narrative;

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Story added successfully!";
                header("location: manage_stories.php");
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
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" id="title" value="<?php echo htmlspecialchars($title); ?>">
                <span class="invalid-feedback"><?php echo $title_err; ?></span>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" name="author" class="form-control <?php echo (!empty($author_err)) ? 'is-invalid' : ''; ?>" id="author" value="<?php echo htmlspecialchars($author); ?>">
                <span class="invalid-feedback"><?php echo $author_err; ?></span>
            </div>
            <div class="mb-3">
                <label for="narrative" class="form-label">Narrative</label>
                <textarea name="narrative" class="form-control <?php echo (!empty($narrative_err)) ? 'is-invalid' : ''; ?>" id="narrative" rows="5"><?php echo htmlspecialchars($narrative); ?></textarea>
                <span class="invalid-feedback"><?php echo $narrative_err; ?></span>
            </div>
            <button type="submit" class="btn btn-primary">Add Story</button>
            <a href="manage_stories.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <?php require_once 'includes/admin_footer.php'; ?>
</body>
</html>
