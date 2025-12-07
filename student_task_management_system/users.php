<?php
session_start();
if (!isset($_SESSION['user'])) header('Location: login.php');

require 'includes/conn.php';
require 'includes/header.php';

$success = "";
$error = "";

if (isset($_POST['add_user'])) {

    $name  = trim($_POST['username']);
    $email = trim($_POST['email']);
    $pass  = trim($_POST['password']);

    if ($name === "" || $email === "" || $pass === "") {
        $error = "All fields are required.";
    } else {

        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            $hashed = password_hash($pass, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed);

            if ($stmt->execute()) {
                $success = "New user added successfully!";
            } else {
                $error = "Failed to create user.";
            }
        }
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id=$id");
    $success = "User deleted successfully.";
}

$users = $conn->query("SELECT id, username, email, created_at FROM users ORDER BY id ASC");

$count_users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
?>

<div class="card shadow-lg p-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="card-title m-0">Registered Users</h2>
        <button class="btn btn-pink btn-sm px-3" data-bs-toggle="collapse" data-bs-target="#addUserForm">
            + Add User
        </button>
    </div>

    <!-- Summary Card -->
    <div class="alert alert-info text-center fw-semibold mb-4">
        Total Registered Users: <?= $count_users ?>
    </div>

    <!-- Alerts -->
    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <!-- Add User Form -->
    <div class="collapse mb-4" id="addUserForm">
        <div class="card card-body">
            <form method="post">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Name</label>
                    <input name="username" class="form-control" placeholder="Example: Aina Sofea" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="example@gmail.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button name="add_user" class="btn btn-pink w-100">Save User</button>
            </form>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="mb-3">
        <input type="text" id="userSearch" class="form-control" placeholder="Search users...">
    </div>

    <!-- Users Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle" id="userTable">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registered At</th>
                    <th style="width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($u = $users->fetch_assoc()): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['username']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['created_at']) ?></td>
                    <td>
                        <a href="?delete=<?= $u['id'] ?>" 
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Delete this user?');">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Search Filter Script -->
<script>
document.getElementById('userSearch').addEventListener('keyup', function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#userTable tbody tr");

    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});
</script>

<?php 
$conn->close();
require 'includes/footer.php';
?>
