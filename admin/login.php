<?php
/**
 * Admin login – email + password.
 * Same theme as auth.html; redirects to dashboard on success.
 */
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

// Already logged in
if (is_admin_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if (!$email || !$pass) {
        $error = 'Please enter email and password.';
    } else {
        $stmt = $pdo->prepare('SELECT id, email, password FROM admins WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && $pass === $admin['password']) {
            $_SESSION['admin_id'] = (int) $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];
            header('Location: dashboard.php');
            exit;
        }
        $error = 'Invalid email or password.';
    }
}

$page_title    = 'Admin Login';
$is_admin      = false;
$is_login_page = true;
require_once __DIR__ . '/../includes/header.php';
?>
<main class="main-content">
    <div class="auth-page">
        <div class="auth-background"></div>
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <div class="auth-logo">
                        <img src="../logo.jpg" alt="VocalFluxStudio">
                    </div>
                    <h1>Admin Login</h1>
                    <p>Sign in to manage links and enquiries</p>
                </div>

                <?php if ($error): ?>
                <div class="form-error" style="margin-bottom: 24px; padding: 16px; background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); border-radius: 12px; color: #f87171;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
                <?php endif; ?>

                <form method="post" action="login.php" class="auth-form">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-input" placeholder="admin@vocalflux.studio"
                            value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required autocomplete="email">
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-input" placeholder="Enter password" required autocomplete="current-password">
                    </div>
                    <button type="submit" class="auth-submit">Sign In</button>
                </form>

                <div class="auth-footer" style="margin-top: 24px;">
                    <a href="../index.html">← Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</main>
<style>
.auth-page { min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 40px 24px; position: relative; overflow: hidden; }
.auth-background { position: absolute; inset: 0; background: radial-gradient(circle at 20% 30%, rgba(139, 92, 246, 0.15), transparent 50%), radial-gradient(circle at 80% 70%, rgba(139, 92, 246, 0.1), transparent 50%), var(--background); z-index: 0; }
.auth-container { position: relative; z-index: 1; width: 100%; max-width: 440px; }
.auth-card { background: linear-gradient(145deg, rgba(22, 21, 35, 0.95), rgba(12, 11, 22, 0.98)); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 32px; padding: 56px 48px; box-shadow: 0 32px 80px rgba(0,0,0,0.6), inset 0 1px 0 rgba(255,255,255,0.04); backdrop-filter: blur(20px); }
.auth-header { text-align: center; margin-bottom: 48px; }
.auth-logo { display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 16px; background: white; padding: 8px; margin-bottom: 24px; }
.auth-logo img { width: 100%; height: 100%; object-fit: contain; }
.auth-header h1 { font-size: 36px; font-weight: 900; margin-bottom: 12px; font-family: 'Space Grotesk', sans-serif; letter-spacing: -0.02em; }
.auth-header p { color: var(--white-50); font-size: 16px; line-height: 1.6; }
.auth-form { display: flex; flex-direction: column; gap: 24px; }
.form-group { display: flex; flex-direction: column; gap: 8px; }
.form-label { font-size: 13px; font-weight: 600; color: var(--white-70); text-transform: uppercase; letter-spacing: 0.1em; }
.form-input { width: 100%; padding: 16px 20px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; color: var(--foreground); font-size: 16px; font-family: 'Inter', sans-serif; }
.form-input:focus { outline: none; border-color: rgba(139, 92, 246, 0.5); background: rgba(255,255,255,0.05); box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1); }
.auth-submit { width: 100%; padding: 18px 32px; background: var(--primary); color: var(--foreground); border: none; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 24px rgba(139, 92, 246, 0.3); }
.auth-submit:hover { background: rgba(139, 92, 246, 0.9); transform: translateY(-2px); }
.auth-footer a { color: var(--primary); text-decoration: none; font-weight: 500; }
.auth-footer a:hover { text-decoration: underline; }
</style>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
