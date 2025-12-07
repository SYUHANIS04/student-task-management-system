<?php 
require 'includes/header.php'; 
require 'includes/conn.php'; 

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name     = trim($_POST['name'] ?? "");
    $email    = trim($_POST['email'] ?? "");
    $password = trim($_POST['password'] ?? "");

    if ($name === "" || $email === "" || $password === "") {
        $error = "All fields are required.";
    } else {

        $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check->bind_param("ss", $name, $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $error = "Username or email is already registered.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $sql->bind_param("sss", $name, $email, $hash);

            if ($sql->execute()) {
                $success = "Registration successful! You may now login.";
            } else {
                $error = "Registration failed. Please try again later.";
            }
        }
    }
}
?>

<div class="row justify-content-center py-5">
  <div class="col-md-6">
    <div class="card shadow-lg rounded-4 p-4">
        
        <h2 class="card-title mb-4 text-center">Create Your Account</h2>

        <!-- Success Message -->
        <?php if ($success): ?>
            <div class="alert alert-success text-center">
                <?= $success; ?>
            </div>
        <?php endif; ?>

        <!-- Error Message -->
        <?php if ($error): ?>
            <div class="alert alert-danger text-center">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" novalidate>

            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <input 
                    name="name" 
                    class="form-control" 
                    required 
                    value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control" 
                    required
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    class="form-control" 
                    required>
            </div>

            <button type="submit" class="btn btn-pink w-100 py-2">
                Register
            </button>
        </form>

        <p class="text-center small text-muted mt-3">
            Already have an account?
            <a href="login.php" class="text-pink">Login here</a>
        </p>

    </div>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
