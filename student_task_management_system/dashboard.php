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

$subjects = $conn->query("SELECT * FROM subjects");

$status_count = ['Pending' => 0, 'In Progress' => 0, 'Completed' => 0];
$task_chart_data = $conn->query("SELECT status, COUNT(*) as count FROM tasks GROUP BY status");
while($row = $task_chart_data->fetch_assoc()) {
    $status_count[$row['status']] = (int)$row['count'];
}

require 'includes/header.php';
?>

<div class="card shadow-lg py-4 px-3 mb-5">
    <h2 class="card-title mb-4">Task List</h2>

    <!-- Chart: Task Status Overview -->
    <div class="mb-4">
        <canvas id="taskStatusChart" height="100"></canvas>
    </div>

    <!-- Button to open Add Task form -->
    <button class="btn btn-pink mb-3" data-bs-toggle="collapse" data-bs-target="#taskForm">+ Add Task</button>

    <!-- Add/Edit Task Form -->
    <div class="collapse mb-4" id="taskForm">
        <div class="card card-body">
            <form method="post">
                <input type="hidden" name="task_id" value="">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <select name="subject_id" class="form-select" required>
                        <?php while($s = $subjects->fetch_assoc()): ?>
                            <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Due Date</label>
                    <input type="date" name="due_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
                <button class="btn btn-pink w-100">Save Task</button>
            </form>
        </div>
    </div>

    <!-- Task Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr><th>ID</th><th>Title</th><th>Subject</th><th>Due Date</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php while($t = $tasks->fetch_assoc()): ?>
                <tr>
                    <td><?= $t['id'] ?></td>
                    <td><?= htmlspecialchars($t['title']) ?></td>
                    <td><?= htmlspecialchars($t['subject']) ?></td>
                    <td><?= $t['due_date'] ?></td>
                    <td><?= $t['status'] ?></td>
                    <td>
                        <a href="?delete=<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('taskStatusChart').getContext('2d');
const taskStatusChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Pending', 'In Progress', 'Completed'],
        datasets: [{
            label: 'Number of Tasks',
            data: [
                <?= $status_count['Pending'] ?>,
                <?= $status_count['In Progress'] ?>,
                <?= $status_count['Completed'] ?>
            ],
            backgroundColor: ['#ffc107', '#17a2b8', '#28a745']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            title: { display: true, text: 'Task Status Overview' }
        },
        scales: {
            y: { beginAtZero: true, precision:0 }
        }
    }
});
</script>

<?php require 'includes/footer.php'; ?>
