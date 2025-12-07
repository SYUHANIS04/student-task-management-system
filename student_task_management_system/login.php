<?php
session_start();
require 'includes/conn.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username'] ?? '');
    $p = trim($_POST['password'] ?? '');

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $u);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($p, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Username not found.";
    }
}

require 'includes/header.php';
?>

<div class="row justify-content-center py-5">
    <div class="col-md-6">
        <div class="card shadow-lg rounded-4 p-4">
            <h2 class="card-title mb-4 text-center">Login to STMS</h2>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post" novalidate>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input name="username" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button class="btn btn-pink w-100">Login</button>
            </form>

            <p class="small text-muted mt-3 text-center">
                No account? <a href="register.php">Register here</a>
            </p>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
