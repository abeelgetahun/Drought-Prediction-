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
                        <h2 class="section-heading mb-4"><i class="fas fa-book-open me-2"></i><?php echo $page_title; ?></h2>

                        <?php 
                        if(!empty($error_message)){
                            echo '<div class="alert alert-danger mb-3">' . $error_message . '</div>';
                        }
                        ?>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
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
                                <textarea name="narrative" class="form-control <?php echo (!empty($narrative_err)) ? 'is-invalid' : ''; ?>" id="narrative" rows="6"><?php echo htmlspecialchars($narrative); ?></textarea>
                                <span class="invalid-feedback"><?php echo $narrative_err; ?></span>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Add Story</button>
                                <a href="manage_stories.php" class="btn btn-secondary">Cancel</a>
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
