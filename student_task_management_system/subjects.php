<?php
session_start();
if(!isset($_SESSION['user'])) header('Location: login.php');

require 'includes/conn.php';

$subjects = $conn->query("SELECT * FROM subjects ORDER BY name ASC");

require 'includes/header.php';
?>

<div class="card shadow-lg py-4 px-3 mb-5">
    <h2 class="card-title mb-4">Subjects / Categories</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Code</th>
                </tr>
            </thead>
            <tbody>
            <?php while($s = $subjects->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($s['id']) ?></td>
                    <td><?= htmlspecialchars($s['name']) ?></td>
                    <td><?= htmlspecialchars($s['code']) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
