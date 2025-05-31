<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$page_title = "Edit Story";
$error_message = '';
$success_message = '';

// Define variables
$title = $author = $narrative = "";
$title_err = $author_err = $narrative_err = "";
$story_id = null;

// Check if ID is provided for editing
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $story_id = trim($_GET["id"]);

    $sql_fetch = "SELECT title, author, narrative FROM stories WHERE id = ?";
    if ($stmt_fetch = $mysqli->prepare($sql_fetch)) {
        $stmt_fetch->bind_param("i", $story_id);
        if ($stmt_fetch->execute()) {
            $stmt_fetch->store_result();
            if ($stmt_fetch->num_rows == 1) {
                $stmt_fetch->bind_result($title, $author, $narrative);
                $stmt_fetch->fetch();
            } else {
                $_SESSION['error_message'] = "Story not found.";
                header("location: manage_stories.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Error fetching story: " . $mysqli->error;
            header("location: manage_stories.php");
            exit();
        }
        $stmt_fetch->close();
    } else {
        $_SESSION['error_message'] = "Error preparing fetch statement: " . $mysqli->error;
        header("location: manage_stories.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "No story ID specified for editing.";
    header("location: manage_stories.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["id"])){
        $error_message = "Story ID is missing from the form submission.";
    } else {
        $story_id = $_POST["id"];
    }

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

    if (empty($title_err) && empty($author_err) && empty($narrative_err) && !empty($story_id)) {
        $sql_update = "UPDATE stories SET title = ?, author = ?, narrative = ? WHERE id = ?";

        if ($stmt_update = $mysqli->prepare($sql_update)) {
            $stmt_update->bind_param("sssi", $param_title, $param_author, $param_narrative, $param_id);

            $param_title = $title;
            $param_author = $author;
            $param_narrative = $narrative;
            $param_id = $story_id;

            if ($stmt_update->execute()) {
                $_SESSION['success_message'] = "Story updated successfully!";
                header("location: manage_stories.php");
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
            <input type="hidden" name="id" value="<?php echo $story_id; ?>"/>
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
            <button type="submit" class="btn btn-primary">Update Story</button>
            <a href="manage_stories.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <?php require_once 'includes/admin_footer.php'; ?>
</body>
</html>
