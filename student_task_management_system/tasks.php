<?php
require 'includes/conn.php';
require 'includes/header.php';

$tasks = $conn->query("
    SELECT t.id, t.title, t.due_date, t.status, s.name AS subject
    FROM tasks t
    JOIN subjects s ON t.subject_id = s.id
    ORDER BY t.due_date ASC
");
?>

<div class="card shadow-lg p-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="card-title m-0">All Tasks</h2>
        <a href="dashboard.php" class="btn btn-outline-pink btn-sm px-3">+ Add Task</a>
    </div>

    <!-- Search Bar -->
    <div class="mb-3">
        <input type="text" id="taskSearch" class="form-control" placeholder="Search tasks...">
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle" id="taskTable">
            <thead>
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
                    <td><?= $t['id'] ?></td>
                    <td><?= htmlspecialchars($t['title']) ?></td>
                    <td><?= htmlspecialchars($t['subject']) ?></td>
                    <td><?= $t['due_date'] ?></td>

                    <td>
                        <?php if($t['status'] === "Pending"): ?>
                            <span class="badge-status badge-pending">Pending</span>
                        <?php elseif($t['status'] === "In Progress"): ?>
                            <span class="badge-status badge-progress">In Progress</span>
                        <?php else: ?>
                            <span class="badge-status badge-completed">Completed</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById('taskSearch').addEventListener('keyup', function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#taskTable tbody tr");

    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});
</script>

<?php require 'includes/footer.php'; ?>
