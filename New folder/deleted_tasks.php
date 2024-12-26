<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM tasks WHERE user_id = $user_id AND status = 'deleted'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Deleted Tasks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Deleted Tasks</h2>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>

        <h3 class="mt-4">Your Deleted Tasks</h3>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($task = $result->fetch_assoc()) : ?>
                <div class="card mt-2">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo htmlspecialchars($task['title']); ?></h4>
                        <p class="card-text"><?php echo htmlspecialchars($task['description']); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No deleted tasks.</p>
        <?php endif; ?>
    </div>
</body>
</html>
