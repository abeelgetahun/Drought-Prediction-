<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$page_title = "Manage Focus Categories";

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM focus WHERE id = ?";
    if ($stmt_delete = $mysqli->prepare($sql_delete)) {
        $stmt_delete->bind_param("i", $delete_id);
        if ($stmt_delete->execute()) {
            $_SESSION['success_message'] = "Focus category deleted successfully.";
        } else {
            $_SESSION['error_message'] = "Error deleting focus category: " . $mysqli->error;
        }
        $stmt_delete->close();
    } else {
        $_SESSION['error_message'] = "Error preparing delete statement: " . $mysqli->error;
    }
    header("Location: manage_focus.php");
    exit;
}

// Fetch all focus categories
$focus_categories = [];
$sql = "SELECT id, name, description FROM focus ORDER BY name ASC";
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $focus_categories[] = $row;
    }
    $result->free();
} else {
    $_SESSION['error_message'] = "Error fetching focus categories: " . $mysqli->error;
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
            if (confirm("Are you sure you want to delete this focus category? This action cannot be undone.")) {
                window.location.href = "manage_focus.php?delete_id=" + id;
            }
        }
    </script>
</head>
<body>
    <?php require_once 'includes/admin_navbar.php'; ?>

    <div class="container mt-5 pt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1><?php echo $page_title; ?></h1>
            <a href="add_focus.php" class="btn btn-primary">Add New Focus Category</a>
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
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($focus_categories)): ?>
                    <?php foreach ($focus_categories as $focus): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($focus['id']); ?></td>
                        <td><?php echo htmlspecialchars($focus['name']); ?></td>
                        <td><?php echo htmlspecialchars(substr($focus['description'], 0, 100) . (strlen($focus['description']) > 100 ? '...' : '')); ?></td>
                        <td>
                            <a href="edit_focus.php?id=<?php echo $focus['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <button onclick="confirmDelete(<?php echo $focus['id']; ?>)" class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No focus categories found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php require_once 'includes/admin_footer.php'; ?>
</body>
</html>
