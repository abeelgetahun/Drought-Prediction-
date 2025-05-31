<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$page_title = "Manage Researchers";

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    // Optional: Add logic to delete photo_url from server if it's a local file
    $sql_delete = "DELETE FROM researchers WHERE id = ?";
    if ($stmt_delete = $mysqli->prepare($sql_delete)) {
        $stmt_delete->bind_param("i", $delete_id);
        if ($stmt_delete->execute()) {
            $_SESSION['success_message'] = "Researcher deleted successfully.";
        } else {
            $_SESSION['error_message'] = "Error deleting researcher: " . $mysqli->error;
        }
        $stmt_delete->close();
    } else {
        $_SESSION['error_message'] = "Error preparing delete statement: " . $mysqli->error;
    }
    header("Location: manage_researchers.php");
    exit;
}

// Fetch all researchers
$researchers = [];
$sql = "SELECT id, name, research_focus FROM researchers ORDER BY name ASC";
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $researchers[] = $row;
    }
    $result->free();
} else {
    $_SESSION['error_message'] = "Error fetching researchers: " . $mysqli->error;
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
            if (confirm("Are you sure you want to delete this researcher? This action cannot be undone.")) {
                window.location.href = "manage_researchers.php?delete_id=" + id;
            }
        }
    </script>
</head>
<body>
    <?php require_once 'includes/admin_navbar.php'; ?>

    <div class="container mt-5 pt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1><?php echo $page_title; ?></h1>
            <a href="add_researcher.php" class="btn btn-primary">Add New Researcher</a>
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
                    <th>Research Focus</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($researchers)): ?>
                    <?php foreach ($researchers as $researcher): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($researcher['id']); ?></td>
                        <td><?php echo htmlspecialchars($researcher['name']); ?></td>
                        <td><?php echo htmlspecialchars($researcher['research_focus']); ?></td>
                        <td>
                            <a href="edit_researcher.php?id=<?php echo $researcher['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <button onclick="confirmDelete(<?php echo $researcher['id']; ?>)" class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No researchers found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php require_once 'includes/admin_footer.php'; ?>
</body>
</html>
