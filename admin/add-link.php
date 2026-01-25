<?php
/**
 * Add or edit link.
 * GET ?id=… for edit; otherwise add.
 */
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_admin();

$id    = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$edit  = $id > 0;
$link  = null;
$error = '';
$done  = '';

if ($edit) {
    $stmt = $pdo->prepare('SELECT id, title, url, type, status FROM links WHERE id = ?');
    $stmt->execute([$id]);
    $link = $stmt->fetch();
    if (!$link) {
        header('Location: dashboard.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title  = trim($_POST['title'] ?? '');
    $url    = trim($_POST['url'] ?? '');
    $type   = $_POST['type'] ?? 'external';
    $status = $_POST['status'] ?? 'active';

    $allowed_types = ['youtube', 'instagram', 'external'];
    $allowed_status = ['active', 'inactive'];
    if (!in_array($type, $allowed_types)) $type = 'external';
    if (!in_array($status, $allowed_status)) $status = 'active';

    if (!$title || !$url) {
        $error = 'Title and URL are required.';
    } else {
        if ($edit) {
            $stmt = $pdo->prepare('UPDATE links SET title = ?, url = ?, type = ?, status = ? WHERE id = ?');
            $stmt->execute([$title, $url, $type, $status, $id]);
            header('Location: dashboard.php?ok=updated');
            exit;
        } else {
            $stmt = $pdo->prepare('INSERT INTO links (title, url, type, status) VALUES (?, ?, ?, ?)');
            $stmt->execute([$title, $url, $type, $status]);
            header('Location: dashboard.php?ok=added');
            exit;
        }
    }
}

$title  = $link['title'] ?? $_POST['title'] ?? '';
$url    = $link['url'] ?? $_POST['url'] ?? '';
$type   = $link['type'] ?? $_POST['type'] ?? 'external';
$status = $link['status'] ?? $_POST['status'] ?? 'active';

$page_title = $edit ? 'Edit Link' : 'Add Link';
$is_admin   = true;
require_once __DIR__ . '/../includes/header.php';
?>
<main class="main-content">
    <div class="container">
        <div style="margin-bottom: 48px;">
            <a href="dashboard.php" style="color: var(--white-50); text-decoration: none; font-size: 14px;">← Dashboard</a>
            <div class="badge" style="margin-top: 16px;"><?php echo $edit ? 'Edit' : 'Add'; ?></div>
            <h1 style="font-size: 36px; font-weight: 900; font-family: 'Space Grotesk', sans-serif; margin-top: 12px;">
                <?php echo $edit ? 'Edit Link' : 'Add Link'; ?>
            </h1>
        </div>

        <div class="auth-card" style="max-width: 560px;">
            <?php if ($error): ?>
            <div style="margin-bottom: 24px; padding: 16px; background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); border-radius: 12px; color: #f87171;">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>

            <form method="post" action="<?php echo $edit ? 'add-link.php?id=' . $id : 'add-link.php'; ?>" class="auth-form">
                <div class="form-group">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" id="title" name="title" class="form-input" placeholder="Link title" value="<?php echo htmlspecialchars($title); ?>" required>
                </div>
                <div class="form-group">
                    <label for="url" class="form-label">URL</label>
                    <input type="text" id="url" name="url" class="form-input" placeholder="https://... or youtu.be/..." value="<?php echo htmlspecialchars($url); ?>" required>
                </div>
                <div class="form-group">
                    <label for="type" class="form-label">Type</label>
                    <select id="type" name="type" class="form-input">
                        <option value="youtube" <?php echo $type === 'youtube' ? 'selected' : ''; ?>>YouTube</option>
                        <option value="instagram" <?php echo $type === 'instagram' ? 'selected' : ''; ?>>Instagram</option>
                        <option value="external" <?php echo $type === 'external' ? 'selected' : ''; ?>>External</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-input">
                        <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo $status === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
                <button type="submit" class="auth-submit"><?php echo $edit ? 'Update Link' : 'Add Link'; ?></button>
            </form>
        </div>
    </div>
</main>
<style>
.auth-card { background: linear-gradient(145deg, rgba(22,21,35,0.95), rgba(12,11,22,0.98)); border: 1px solid rgba(255,255,255,0.08); border-radius: 32px; padding: 48px; }
.auth-form { display: flex; flex-direction: column; gap: 24px; }
.form-group { display: flex; flex-direction: column; gap: 8px; }
.form-label { font-size: 13px; font-weight: 600; color: var(--white-70); text-transform: uppercase; letter-spacing: 0.1em; }
.form-input { width: 100%; padding: 16px 20px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; color: var(--foreground); font-size: 16px; font-family: 'Inter', sans-serif; }
.form-input:focus { outline: none; border-color: rgba(139,92,246,0.5); background: rgba(255,255,255,0.05); }
select.form-input { cursor: pointer; }
.auth-submit { width: 100%; padding: 18px 32px; background: var(--primary); color: var(--foreground); border: none; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; box-shadow: 0 8px 24px rgba(139,92,246,0.3); }
.auth-submit:hover { background: rgba(139,92,246,0.9); transform: translateY(-2px); }
</style>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
