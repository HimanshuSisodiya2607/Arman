<?php
/**
 * Admin – view enquiry form submissions.
 */
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_admin();

$stmt = $pdo->query('SELECT id, name, email, phone, message, created_at FROM enquiries ORDER BY created_at DESC');
$enquiries = $stmt->fetchAll();

$page_title = 'Enquiries';
$is_admin   = true;
require_once __DIR__ . '/../includes/header.php';
?>
<main class="main-content">
    <div class="container">
        <div style="margin-bottom: 48px;">
            <a href="dashboard.php" style="color: var(--white-50); text-decoration: none; font-size: 14px;">← Dashboard</a>
            <div class="badge" style="margin-top: 16px;">Enquiries</div>
            <h1 style="font-size: 36px; font-weight: 900; font-family: 'Space Grotesk', sans-serif; margin-top: 12px;">Enquiry Submissions</h1>
            <p style="color: var(--white-50); margin-top: 8px;">Name, email, phone, message from the contact form</p>
        </div>

        <?php if (empty($enquiries)): ?>
        <article class="how-card" style="text-align: center; padding: 80px 48px;">
            <p class="how-kicker">No enquiries yet</p>
            <h3>Enquiries will appear here</h3>
            <p style="color: var(--white-50); margin-top: 24px;">Submissions from the public enquiry form.</p>
        </article>
        <?php else: ?>
        <div class="how-cards" style="grid-template-columns: 1fr;">
            <?php foreach ($enquiries as $e): ?>
            <article class="how-card">
                <p class="how-kicker"><?php echo htmlspecialchars(date('M j, Y H:i', strtotime($e['created_at']))); ?></p>
                <h3><?php echo htmlspecialchars($e['name']); ?></h3>
                <p style="color: var(--primary); font-size: 14px; margin-bottom: 8px;">
                    <a href="mailto:<?php echo htmlspecialchars($e['email']); ?>" style="color: inherit;"><?php echo htmlspecialchars($e['email']); ?></a>
                </p>
                <?php if (!empty($e['phone'])): ?>
                <p style="color: var(--white-60); font-size: 14px; margin-bottom: 16px;">
                    <a href="tel:<?php echo htmlspecialchars(preg_replace('/\s+/', '', $e['phone'])); ?>" style="color: inherit;"><?php echo htmlspecialchars($e['phone']); ?></a>
                </p>
                <?php endif; ?>
                <p style="color: var(--white-70); line-height: 1.7; white-space: pre-wrap;"><?php echo htmlspecialchars($e['message']); ?></p>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
