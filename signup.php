<?php
require_once 'includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($full_name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Email already registered. Please login.";
        } else {
            // Create user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
            try {
                $stmt->execute([$full_name, $email, $hashed_password]);
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['user_name'] = $full_name;
                header("Location: index.php");
                exit;
            } catch (PDOException $e) {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<div class="auth-container">
    <div class="auth-box">
        <h2 style="margin-bottom: 24px; text-align: center;">Create an account</h2>
        
        <?php if($error): ?>
            <div style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="signup.php">
            <div class="form-group" style="padding: 0; border: none; margin-bottom: 16px;">
                <label style="font-weight: 500; font-size: 0.9rem;">Full Name</label>
                <input type="text" name="full_name" required placeholder="John Doe" style="width: 100%; border: 1px solid #ccc; border-radius: 8px; padding: 12px;">
            </div>

            <div class="form-group" style="padding: 0; border: none; margin-bottom: 16px;">
                <label style="font-weight: 500; font-size: 0.9rem;">Email Address</label>
                <input type="email" name="email" required placeholder="name@example.com" style="width: 100%; border: 1px solid #ccc; border-radius: 8px; padding: 12px;">
            </div>

            <div class="form-group" style="padding: 0; border: none; margin-bottom: 16px;">
                <label style="font-weight: 500; font-size: 0.9rem;">Password</label>
                <input type="password" name="password" required placeholder="Min 6 characters" style="width: 100%; border: 1px solid #ccc; border-radius: 8px; padding: 12px;">
            </div>

            <div class="form-group" style="padding: 0; border: none; margin-bottom: 24px;">
                <label style="font-weight: 500; font-size: 0.9rem;">Confirm Password</label>
                <input type="password" name="confirm_password" required placeholder="Re-enter password" style="width: 100%; border: 1px solid #ccc; border-radius: 8px; padding: 12px;">
            </div>

            <button type="submit" class="search-btn" style="width: 100%; justify-content: center; font-size: 1rem;">Sign Up</button>
        </form>

        <div style="margin-top: 20px; text-align: center; font-size: 0.9rem; color: #666;">
            Already have an account? <a href="login.php" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">Log in</a>
        </div>
    </div>
</div>

<style>
.auth-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
    padding: 20px;
}

.auth-box {
    background: var(--white);
    padding: 40px;
    border-radius: 16px;
    box-shadow: var(--shadow-md);
    width: 100%;
    max-width: 450px;
    border: 1px solid rgba(0,0,0,0.1);
}
</style>

<?php require_once 'includes/footer.php'; ?>
