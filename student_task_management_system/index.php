<?php require 'includes/header.php'; ?>

<div class="py-5 text-center">

    <h1 class="fw-bold display-5 mb-3 text-pink">
        Student Task Management System
    </h1>

    <p class="lead text-muted mb-4 px-3">
        A simple and modern platform to help students manage tasks, deadlines, and track academic progress visually.
    </p>

    <!-- Simple icon illustration (Bootstrap Icon) -->
    <div class="mb-4">
        <svg width="100" height="100" fill="#FF69B4" viewBox="0 0 16 16">
            <path d="M2 2a2 2 0 0 1 2-2h5.5a2 2 0 0 1 1.4.6l2.5 2.5a2 2 0 0 1 .6 1.4V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2z"/>
        </svg>
    </div>

    <?php if(!isset($_SESSION['user'])): ?>
        <a href="login.php" class="btn btn-pink btn-lg px-4">
            Login Now
        </a>
    <?php else: ?>
        <a href="dashboard.php" class="btn btn-outline-pink btn-lg px-4">
            Go to Dashboard
        </a>
    <?php endif; ?>

</div>

<!-- Features Section -->
<div class="container mb-5">
    <div class="row g-4">

        <div class="col-md-4">
            <div class="card p-4 h-100">
                <h5 class="card-title">📌 Manage Tasks</h5>
                <p class="text-muted">
                    Add, update, and organize your academic tasks with ease.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 h-100">
                <h5 class="card-title">📚 Track Subjects</h5>
                <p class="text-muted">
                    View all your subjects and monitor progress in one place.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 h-100">
                <h5 class="card-title">📊 Visual Analytics</h5>
                <p class="text-muted">
                    Understand performance with charts and simple visual data.
                </p>
            </div>
        </div>

    </div>
</div>

<?php require 'includes/footer.php'; ?>
