<?php
/**
 * Admin dashboard – list links, add/edit/delete, link to enquiries.
 * Same theme as landing.
 */
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_admin();

$stmt = $pdo->query('SELECT id, title, url, type, status, created_at FROM links ORDER BY created_at DESC');
$links = $stmt->fetchAll();

$ok = $_GET['ok'] ?? '';

$page_title = 'Dashboard';
$is_admin   = true;
require_once __DIR__ . '/../includes/header.php';
?>
<main class="main-content">
    <div class="container">
        <?php if ($ok === 'added' || $ok === 'updated'): ?>
        <div style="margin-bottom: 24px; padding: 16px; background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3); border-radius: 12px; color: #4ade80;">
            <?php echo $ok === 'added' ? 'Link added.' : 'Link updated.'; ?>
        </div>
        <?php endif; ?>
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 24px; margin-bottom: 48px;">
            <div>
                <div class="badge">Admin</div>
                <h1 style="font-size: 36px; font-weight: 900; font-family: 'Space Grotesk', sans-serif; margin-top: 12px;">Dashboard</h1>
                <p style="color: var(--white-50); margin-top: 8px;">Manage links and view enquiries</p>
            </div>
            <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                <a href="add-link.php" class="btn-primary-large">Add Link</a>
                <a href="enquiries.php" class="btn-outline-large">View Enquiries</a>
            </div>
        </div>

        <section class="how-it-works" style="padding: 0;">
            <div class="how-cards">
                <?php if (empty($links)): ?>
                <article class="how-card" style="grid-column: 1 / -1; text-align: center; padding: 80px 48px;">
                    <p class="how-kicker">No links yet</p>
                    <h3>Add your first link</h3>
                    <p style="color: var(--white-50); margin: 24px 0;">YouTube, Instagram, or external URLs.</p>
                    <a href="add-link.php" class="btn-primary-large" style="display: inline-block;">Add Link</a>
                </article>
                <?php else: ?>
                <?php foreach ($links as $link): ?>
                <article class="how-card">
                    <div class="how-icon <?php echo htmlspecialchars($link['type']); ?>">
                        <?php
                        if ($link['type'] === 'youtube') echo '▶';
                        elseif ($link['type'] === 'instagram') echo '📷';
                        else echo '🔗';
                        ?>
                    </div>
                    <p class="how-kicker"><?php echo htmlspecialchars($link['type']); ?></p>
                    <h3><?php echo htmlspecialchars($link['title']); ?></h3>
                    <p style="color: var(--white-50); font-size: 14px; margin-bottom: 16px; word-break: break-all;"><?php echo htmlspecialchars($link['url']); ?></p>
                    <p style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--white-40); margin-bottom: 20px;">
                        Status: <span style="color: <?php echo $link['status'] === 'active' ? 'var(--primary)' : 'var(--white-40)'; ?>"><?php echo htmlspecialchars($link['status']); ?></span>
                    </p>
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <a href="add-link.php?id=<?php echo (int) $link['id']; ?>" class="btn-outline-large" style="padding: 12px 24px; font-size: 14px;">Edit</a>
                        <a href="delete-link.php?id=<?php echo (int) $link['id']; ?>" class="btn-ghost" style="padding: 12px 24px; font-size: 14px; color: #f87171;" onclick="return confirm('Delete this link?');">Delete</a>
                    </div>
                </article>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
