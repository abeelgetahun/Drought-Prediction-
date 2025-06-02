<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$page_title = "Manage Stories";

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM stories WHERE id = ?";
    if ($stmt_delete = $mysqli->prepare($sql_delete)) {
        $stmt_delete->bind_param("i", $delete_id);
        if ($stmt_delete->execute()) {
            $_SESSION['success_message'] = "Story deleted successfully.";
        } else {
            $_SESSION['error_message'] = "Error deleting story: " . $mysqli->error;
        }
        $stmt_delete->close();
    } else {
        $_SESSION['error_message'] = "Error preparing delete statement: " . $mysqli->error;
    }
    header("Location: manage_stories.php");
    exit;
}

// Fetch all stories
$stories = [];
$sql = "SELECT id, title, author, publish_date FROM stories ORDER BY publish_date DESC";
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $stories[] = $row;
    }
    $result->free();
} else {
    $_SESSION['error_message'] = "Error fetching stories: " . $mysqli->error;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-bottom: 70px;
        }
        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: 700;
            color: white;
        }
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            border-radius: 4px;
            margin: 0 5px;
            transition: all 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            color: white !important;
            background-color: rgba(255,255,255,0.1);
        }
        .table {
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border-radius: 10px;
            overflow: hidden;
            background-color: white;
        }
        .table thead th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            border: none;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        .btn-action {
            margin: 0 3px;
        }
        .btn-edit {
            background-color: #f39c12;
            border-color: #f39c12;
            color: white;
        }
        .btn-edit:hover {
            background-color: #e67e22;
            border-color: #e67e22;
            color: white;
        }
        .btn-delete {
            background-color: #e74c3c;
            border-color: #e74c3c;
            color: white;
        }
        .btn-delete:hover {
            background-color: #c0392b;
            border-color: #c0392b;
            color: white;
        }
        .footer {
            background-color: var(--primary-color);
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .section-heading {
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--dark-color);
            border-bottom: 2px solid var(--secondary-color);
            padding-bottom: 10px;
            display: inline-block;
        }
        .add-new-btn {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .add-new-btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            color: white;
        }
        .empty-state {
            text-align: center;
            padding: 50px 0;
        }
        .empty-icon {
            font-size: 50px;
            color: #bdc3c7;
            margin-bottom: 20px;
        }
    </style>
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this story? This action cannot be undone.")) {
                window.location.href = "manage_stories.php?delete_id=" + id;
            }
        }
    </script>
</head>
<body>
    <?php require_once 'includes/admin_navbar.php'; ?>

    <div class="container mt-5 pt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="section-heading"><i class="fas fa-book-open me-2"></i><?php echo $page_title; ?></h1>
            <a href="add_story.php" class="btn add-new-btn">
                <i class="fas fa-plus me-2"></i> Add New Story
            </a>
        </div>

        <?php
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>' . $_SESSION['success_message'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>' . $_SESSION['error_message'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
            unset($_SESSION['error_message']);
        }
        ?>

        <div class="card">
            <div class="card-body p-0">
                <?php if (!empty($stories)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Publish Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stories as $story): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($story['id']); ?></td>
                                    <td><?php echo htmlspecialchars($story['title']); ?></td>
                                    <td><?php echo htmlspecialchars($story['author']); ?></td>
                                    <td><?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($story['publish_date']))); ?></td>
                                    <td class="text-end">
                                        <a href="edit_story.php?id=<?php echo $story['id']; ?>" class="btn btn-sm btn-edit btn-action">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button onclick="confirmDelete(<?php echo $story['id']; ?>)" class="btn btn-sm btn-delete btn-action">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-book-open empty-icon"></i>
                        <h4>No Stories Found</h4>
                        <p class="text-muted">Get started by adding your first story.</p>
                        <a href="add_story.php" class="btn btn-primary mt-3">
                            <i class="fas fa-plus me-2"></i> Add Story
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php require_once 'includes/admin_footer.php'; ?>
</body>
</html>
