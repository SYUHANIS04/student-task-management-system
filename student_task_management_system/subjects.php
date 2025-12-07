<?php
require 'includes/conn.php';
require 'includes/header.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $code = trim($_POST['code']);

    if ($name === "" || $code === "") {
        $error = "Please fill in all fields.";
    } else {
        $check = $conn->prepare("SELECT id FROM subjects WHERE code = ?");
        $check->bind_param("s", $code);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $error = "Subject code already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO subjects (name, code) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $code);

            if ($stmt->execute()) {
                $success = "New subject added successfully.";
            } else {
                $error = "Failed to add subject.";
            }
        }
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM subjects WHERE id=$id");
    $success = "Subject deleted successfully.";
}

$subjects = $conn->query("SELECT * FROM subjects ORDER BY name ASC");
?>

<div class="card shadow-lg p-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="card-title m-0">Subjects / Categories</h2>
        <button class="btn btn-pink btn-sm px-3" data-bs-toggle="collapse" data-bs-target="#addSubjectForm">+ Add Subject</button>
    </div>

    <!-- Alerts -->
    <?php if($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <!-- Add Subject Form -->
    <div class="collapse mb-4" id="addSubjectForm">
        <div class="card card-body">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Subject Name</label>
                    <input name="name" class="form-control" placeholder="Example: Mathematics" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Subject Code</label>
                    <input name="code" class="form-control" placeholder="Example: MATH101" required>
                </div>

                <button class="btn btn-pink w-100">Save Subject</button>
            </form>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="mb-3">
        <input type="text" id="subjectSearch" class="form-control" placeholder="Search subjects...">
    </div>

    <!-- Subjects Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle" id="subjectTable">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th style="width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while($s = $subjects->fetch_assoc()): ?>
                <tr>
                    <td><?= $s['id'] ?></td>
                    <td><?= htmlspecialchars($s['name']) ?></td>
                    <td><?= htmlspecialchars($s['code']) ?></td>
                    <td>
                        <a href="?delete=<?= $s['id'] ?>" 
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Delete this subject?');">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Search Filter -->
<script>
document.getElementById('subjectSearch').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#subjectTable tbody tr");

    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});
</script>

<?php require 'includes/footer.php'; ?>
