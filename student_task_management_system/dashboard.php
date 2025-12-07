<?php
session_start();
if(!isset($_SESSION['user'])) header('Location: login.php');

require 'includes/conn.php';
require 'includes/header.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_task'])) {
    $title      = trim($_POST['title']);
    $subject_id = $_POST['subject_id'];
    $due_date   = $_POST['due_date'];
    $status     = $_POST['status'];

    if ($title && $subject_id && $due_date && $status) {
        $stmt = $conn->prepare("INSERT INTO tasks (title, subject_id, due_date, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $title, $subject_id, $due_date, $status);

        if ($stmt->execute()) {
            $success = "Task successfully added.";
        } else {
            $error = "Failed to add task.";
        }
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM tasks WHERE id = $id");
    $success = "Task deleted successfully.";
}

$tasks = $conn->query("
    SELECT t.id, t.title, t.due_date, t.status, s.name AS subject
    FROM tasks t
    JOIN subjects s ON t.subject_id = s.id
    ORDER BY t.due_date ASC
");

$subjects = $conn->query("SELECT * FROM subjects");

$status_count = ['Pending'=>0, 'In Progress'=>0, 'Completed'=>0];
$result = $conn->query("SELECT status, COUNT(*) AS total FROM tasks GROUP BY status");
while ($row = $result->fetch_assoc()) {
    $status_count[$row['status']] = (int)$row['total'];
}

$total_tasks    = array_sum($status_count);
$total_subjects = $conn->query("SELECT COUNT(*) AS t FROM subjects")->fetch_assoc()['t'];
$total_users    = $conn->query("SELECT COUNT(*) AS t FROM users")->fetch_assoc()['t'];
?>

<!-- Page Title -->
<div class="mb-4">
    <h2 class="fw-bold text-center mb-3">Dashboard Overview</h2>
    <p class="text-center text-muted">Quick insights into your tasks and progress.</p>
</div>

<!-- Alerts -->
<?php if($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<?php if($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>


<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm p-3 text-center">
            <h5 class="text-pink">Total Tasks</h5>
            <h3 class="fw-bold"><?= $total_tasks ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm p-3 text-center">
            <h5 class="text-pink">Subjects</h5>
            <h3 class="fw-bold"><?= $total_subjects ?></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm p-3 text-center">
            <h5 class="text-pink">Registered Users</h5>
            <h3 class="fw-bold"><?= $total_users ?></h3>
        </div>
    </div>
</div>


<!-- Chart Section -->
<div class="card shadow-lg p-4 mb-4">
    <h4 class="card-title mb-3">Task Status Overview</h4>
    <canvas id="taskChart" height="120"></canvas>
</div>


<!-- ADD TASK BUTTON -->
<button class="btn btn-pink mb-3" data-bs-toggle="collapse" data-bs-target="#addTaskForm">+ Add Task</button>

<!-- ADD TASK FORM -->
<div class="collapse mb-4" id="addTaskForm">
    <div class="card card-body shadow-sm">
        <form method="post">

            <input type="hidden" name="add_task" value="1">

            <div class="mb-3">
                <label class="form-label">Task Title</label>
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
                    <option>Pending</option>
                    <option>In Progress</option>
                    <option>Completed</option>
                </select>
            </div>

            <button class="btn btn-pink w-100">Save Task</button>

        </form>
    </div>
</div>


<!-- RECENT TASKS TABLE -->
<div class="card shadow-lg p-4 mb-5">
    <h4 class="card-title mb-3">Recent Tasks</h4>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Subject</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Action</th>
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
                        <span class="badge 
                            <?= $t['status'] === 'Completed' ? 'bg-success' : 
                               ($t['status'] === 'In Progress' ? 'bg-info' : 'bg-warning'); ?>">
                            <?= $t['status'] ?>
                        </span>
                    </td>

                    <td>
                        <a href="?delete=<?= $t['id'] ?>" 
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Delete this task?')">Delete</a>
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
const ctx = document.getElementById('taskChart').getContext('2d');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'In Progress', 'Completed'],
        datasets: [{
            data: [
                <?= $status_count['Pending'] ?>,
                <?= $status_count['In Progress'] ?>,
                <?= $status_count['Completed'] ?>
            ],
            backgroundColor: ['#FFB6C1', '#87CEEB', '#90EE90'],
            borderColor: "#fff",
            borderWidth: 2
        }]
    },
    options: {
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
</script>

<?php require 'includes/footer.php'; ?>
