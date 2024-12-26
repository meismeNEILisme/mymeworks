<?php
session_start();
include 'db.php';

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $task_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Mark the task as deleted
    $stmt = $conn->prepare("UPDATE tasks SET status = 'deleted' WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Failed to delete task!";
    }
}
?>
