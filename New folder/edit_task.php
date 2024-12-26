<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $result = $conn->query("SELECT * FROM tasks WHERE id = $task_id");
    $task = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $task_id = $_POST['task_id'];

    $stmt = $conn->prepare("UPDATE tasks SET title = ?, description = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $description, $task_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Failed to update task!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Task</h2>
        <form method="POST" action="">
            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description"><?php echo htmlspecialchars($task['description']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Task</button>
        </form>
    </div>
</body>
</html>

