<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$page_title = "Manage News";

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM news WHERE id = ?";
    if ($stmt_delete = $mysqli->prepare($sql_delete)) {
        $stmt_delete->bind_param("i", $delete_id);
        if ($stmt_delete->execute()) {
            $_SESSION['success_message'] = "News article deleted successfully.";
        } else {
            $_SESSION['error_message'] = "Error deleting news article: " . $mysqli->error;
        }
        $stmt_delete->close();
    } else {
        $_SESSION['error_message'] = "Error preparing delete statement: " . $mysqli->error;
    }
    header("Location: manage_news.php"); // Redirect to refresh the page and messages
    exit;
}

// Fetch all news articles
$news_articles = [];
$sql = "SELECT id, title, publish_date FROM news ORDER BY publish_date DESC";
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $news_articles[] = $row;
    }
    $result->free();
} else {
    // Handle error, maybe set an error message
    $_SESSION['error_message'] = "Error fetching news: " . $mysqli->error;
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
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this news article?")) {
                window.location.href = "manage_news.php?delete_id=" + id;
            }
        }
    </script>
</head>
<body>
    <?php require_once 'includes/admin_navbar.php'; ?>

    <div class="container mt-5 pt-5 mb-5"> {/* Adjusted pt-5 and added mb-5 for footer */}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1><?php echo $page_title; ?></h1>
            <a href="add_news.php" class="btn btn-primary">Add New News</a>
        </div>

        <?php
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
        }
        ?>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Publish Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($news_articles)): ?>
                    <?php foreach ($news_articles as $article): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($article['id']); ?></td>
                        <td><?php echo htmlspecialchars($article['title']); ?></td>
                        <td><?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($article['publish_date']))); ?></td>
                        <td>
                            <a href="edit_news.php?id=<?php echo $article['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <button onclick="confirmDelete(<?php echo $article['id']; ?>)" class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No news articles found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php require_once 'includes/admin_footer.php'; ?>
