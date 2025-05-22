<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$page_title = "Manage Events";

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM events WHERE id = ?";
    if ($stmt_delete = $mysqli->prepare($sql_delete)) {
        $stmt_delete->bind_param("i", $delete_id);
        if ($stmt_delete->execute()) {
            $_SESSION['success_message'] = "Event deleted successfully.";
        } else {
            $_SESSION['error_message'] = "Error deleting event: " . $mysqli->error;
        }
        $stmt_delete->close();
    } else {
        $_SESSION['error_message'] = "Error preparing delete statement: " . $mysqli->error;
    }
    header("Location: manage_events.php");
    exit;
}

// Fetch all events
$events = [];
$sql = "SELECT id, name, event_date, location FROM events ORDER BY event_date DESC";
if ($result = $mysqli->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
    $result->free();
} else {
    $_SESSION['error_message'] = "Error fetching events: " . $mysqli->error;
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
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this event?")) {
                window.location.href = "manage_events.php?delete_id=" + id;
            }
        }
    </script>
</head>
<body>
    <?php require_once 'includes/admin_navbar.php'; ?>

    <div class="container mt-5 pt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1><?php echo $page_title; ?></h1>
            <a href="add_event.php" class="btn btn-primary">Add New Event</a>
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
                    <th>Event Date</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($event['id']); ?></td>
                        <td><?php echo htmlspecialchars($event['name']); ?></td>
                        <td><?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($event['event_date']))); ?></td>
                        <td><?php echo htmlspecialchars($event['location']); ?></td>
                        <td>
                            <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <button onclick="confirmDelete(<?php echo $event['id']; ?>)" class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No events found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php require_once 'includes/admin_footer.php'; ?>
</body>
</html>
