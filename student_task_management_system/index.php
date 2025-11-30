<?php require 'includes/header.php'; ?>

<div class="text-center py-5">
    <h1 class="display-4 fw-bold mb-3">Student Task Management System (STMS)</h1>
    <p class="lead text-muted mb-4">Manage tasks, deadlines, and track progress visually.</p>

    <?php if(!isset($_SESSION['user'])): ?>
        <a href="login.php" class="btn btn-pink btn-lg px-4">Login Now</a>
    <?php else: ?>
        <a href="dashboard.php" class="btn btn-outline-pink btn-lg px-4">Go to Dashboard</a>
    <?php endif; ?>
</div>

<?php require 'includes/footer.php'; ?>
