<?php
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username'] ?? '');
    $p = trim($_POST['password'] ?? '');

    if ($u === 'Syuhanis' && $p === '1010') {
        $_SESSION['user'] = 'Syuhanis';
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}

require 'includes/header.php';
?>

<div class="row justify-content-center py-5">
    <div class="col-md-6">
        <div class="card shadow-lg rounded-4 p-4">
            <h2 class="card-title mb-4 text-center">Login to STMS</h2>

            <?php if($error): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error) ?>
                </div>
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
                Test credentials: <strong>Syuhanis / 1010</strong>
            </p>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
