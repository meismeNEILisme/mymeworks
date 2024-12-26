<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM tasks WHERE user_id = $user_id AND status = 'pending'");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome to Your To-Do List</h2>
        <a href="logout.php" class="btn btn-secondary float-right">Logout</a>
        <a href="completed_tasks.php" class="btn btn-primary">View Completed Tasks</a>
        <a href="deleted_tasks.php" class="btn btn-warning">View Deleted Tasks</a>


        <h3 class="mt-4">Add New Task</h3>
        <form method="POST" action="add_task.php">
            <div class="form-group">
                <input type="text" class="form-control" name="title" placeholder="Task Title" required>
            </div>
            <div class="form-group">
                <textarea class="form-control" name="description" placeholder="Task Description"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Add Task</button>
        </form>

        <h3 class="mt-4">Your Pending Tasks</h3>
        <?php while ($task = $result->fetch_assoc()) : ?>
            <div class="card mt-2">
                <div class="card-body">
                    <h4 class="card-title"><?php echo htmlspecialchars($task['title']); ?></h4>
                    <p class="card-text"><?php echo htmlspecialchars($task['description']); ?></p>
                    <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn btn-info">Edit</a>
                    <a href="delete_task.php?id=<?php echo $task['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                    <a href="mark_completed.php?id=<?php echo $task['id']; ?>" class="btn btn-success">Mark as Completed</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
