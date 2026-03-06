<?php
require_once 'includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        $stmt = $pdo->prepare("SELECT id, full_name, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>

<div class="auth-container">
    <div class="auth-box">
        <h2 style="margin-bottom: 24px; text-align: center;">Welcome back</h2>
        
        <?php if($error): ?>
            <div style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="form-group" style="padding: 0; border: none; margin-bottom: 16px;">
                <label style="font-weight: 500; font-size: 0.9rem;">Email Address</label>
                <input type="email" name="email" required placeholder="name@example.com" style="width: 100%; border: 1px solid #ccc; border-radius: 8px; padding: 12px;">
            </div>

            <div class="form-group" style="padding: 0; border: none; margin-bottom: 24px;">
                <label style="font-weight: 500; font-size: 0.9rem;">Password</label>
                <input type="password" name="password" required placeholder="Enter your password" style="width: 100%; border: 1px solid #ccc; border-radius: 8px; padding: 12px;">
            </div>

            <button type="submit" class="search-btn" style="width: 100%; justify-content: center; font-size: 1rem;">Log In</button>
        </form>

        <div style="margin-top: 20px; text-align: center; font-size: 0.9rem; color: #666;">
            Don't have an account? <a href="signup.php" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">Sign up</a>
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
