<?php
session_start();
if(!isset($_SESSION['user'])) header('Location: login.php');

require 'includes/conn.php';

$tasks = $conn->query("
    SELECT t.id, t.title, t.due_date, t.status, s.name AS subject
    FROM tasks t
    JOIN subjects s ON t.subject_id = s.id
    ORDER BY t.due_date ASC
");

require 'includes/header.php';
?>

<div class="card shadow-lg py-4 px-3 mb-5">
    <h2 class="card-title mb-4">Task List</h2>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Subject</th>
                    <th>Due Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php while($t = $tasks->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($t['id']) ?></td>
                    <td><?= htmlspecialchars($t['title']) ?></td>
                    <td><?= htmlspecialchars($t['subject']) ?></td>
                    <td><?= htmlspecialchars($t['due_date']) ?></td>
                    <td><?= htmlspecialchars($t['status']) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
