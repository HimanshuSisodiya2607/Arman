<?php
/**
 * Client public page – active links (YouTube embed, Instagram embed or new tab, external new tab) + enquiry form.
 * Same theme as landing.
 */
require_once __DIR__ . '/includes/db.php';

$stmt = $pdo->query("SELECT id, title, url, type FROM links WHERE status = 'active' ORDER BY created_at DESC");
$links = $stmt->fetchAll();

/**
 * Extract YouTube video ID from URL.
 */
function youtube_video_id($url) {
    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $url, $m)) {
        return $m[1];
    }
    return null;
}

/**
 * Fetch Instagram oEmbed HTML if possible.
 */
function instagram_embed_html($url) {
    $api = 'https://api.instagram.com/oembed?url=' . rawurlencode($url) . '&maxwidth=540';
    $ctx = stream_context_create(['http' => ['timeout' => 3]]);
    $raw = @file_get_contents($api, false, $ctx);
    if ($raw === false) return null;
    $data = @json_decode($raw, true);
    return isset($data['html']) ? $data['html'] : null;
}

$page_title = 'Links';
$is_admin   = false;
require_once __DIR__ . '/includes/header.php';
?>
<main class="main-content">
    <section class="how-it-works" id="links">
        <div class="container">
            <div class="badge">Active</div>
            <h2 style="font-size: 44px; font-weight: 900; font-family: 'Space Grotesk', sans-serif; margin-top: 12px; margin-bottom: 16px;">Links</h2>
            <p style="color: var(--white-50); font-size: 18px; margin-bottom: 48px;">YouTube, Instagram, and external links.</p>

            <?php if (empty($links)): ?>
            <article class="how-card" style="text-align: center; padding: 80px 48px;">
                <p class="how-kicker">No active links</p>
                <h3>Check back later</h3>
                <p style="color: var(--white-50); margin-top: 24px;">There are no links to show right now.</p>
            </article>
            <?php else: ?>
            <div class="how-cards">
                <?php foreach ($links as $link):
                    $type = $link['type'];
                    $url  = $link['url'];
                    $vid  = $type === 'youtube' ? youtube_video_id($url) : null;
                    $ig   = $type === 'instagram' ? instagram_embed_html($url) : null;
                ?>
                <article class="how-card">
                    <div class="how-icon">
                        <?php
                        if ($type === 'youtube') echo '▶';
                        elseif ($type === 'instagram') echo '📷';
                        else echo '🔗';
                        ?>
                    </div>
                    <p class="how-kicker"><?php echo htmlspecialchars($type); ?></p>
                    <h3><?php echo htmlspecialchars($link['title']); ?></h3>
                    <?php if ($type === 'youtube' && $vid): ?>
                    <div class="link-embed" style="margin-top: 24px; border-radius: 16px; overflow: hidden; aspect-ratio: 16/9; background: #000;">
                        <iframe src="https://www.youtube.com/embed/<?php echo htmlspecialchars($vid); ?>" title="<?php echo htmlspecialchars($link['title']); ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width:100%;height:100%;border:0;"></iframe>
                    </div>
                    <?php elseif ($type === 'instagram' && $ig): ?>
                    <div class="link-embed link-embed-ig" style="margin-top: 24px;">
                        <?php echo $ig; ?>
                    </div>
                    <?php else: ?>
                    <p style="margin-top: 20px;">
                        <a href="<?php echo htmlspecialchars($url); ?>" target="_blank" rel="noopener noreferrer" class="btn-primary-large" style="display: inline-block;">Open link</a>
                    </p>
                    <?php endif; ?>
                </article>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <section id="enquiry" class="security-features" style="padding-top: 80px; padding-bottom: 120px;">
        <div class="container">
            <div class="badge">Contact</div>
            <h2 style="font-size: 44px; font-weight: 900; font-family: 'Space Grotesk', sans-serif; margin-top: 12px; margin-bottom: 16px;">Enquiry</h2>
            <p style="color: var(--white-50); font-size: 18px; margin-bottom: 48px;">Name, email, phone, and message.</p>

            <div class="auth-card" style="max-width: 560px;">
                <div id="enquiry-message" style="display:none; margin-bottom: 24px; padding: 16px; border-radius: 12px;"></div>
                <form id="enquiry-form" class="auth-form">
                    <div class="form-group">
                        <label for="enquiry-name" class="form-label">Name</label>
                        <input type="text" id="enquiry-name" name="name" class="form-input" placeholder="Your name" required>
                    </div>
                    <div class="form-group">
                        <label for="enquiry-email" class="form-label">Email</label>
                        <input type="email" id="enquiry-email" name="email" class="form-input" placeholder="your@email.com" required>
                    </div>
                    <div class="form-group">
                        <label for="enquiry-phone" class="form-label">Phone</label>
                        <input type="tel" id="enquiry-phone" name="phone" class="form-input" placeholder="+1 234 567 8900">
                    </div>
                    <div class="form-group">
                        <label for="enquiry-message-field" class="form-label">Message</label>
                        <textarea id="enquiry-message-field" name="message" class="form-input" placeholder="Your message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="auth-submit" id="enquiry-submit">Submit</button>
                </form>
            </div>
        </div>
    </section>
</main>
<style>
.auth-card { background: linear-gradient(145deg, rgba(22,21,35,0.95), rgba(12,11,22,0.98)); border: 1px solid rgba(255,255,255,0.08); border-radius: 32px; padding: 48px; }
.auth-form { display: flex; flex-direction: column; gap: 24px; }
.form-group { display: flex; flex-direction: column; gap: 8px; }
.form-label { font-size: 13px; font-weight: 600; color: var(--white-70); text-transform: uppercase; letter-spacing: 0.1em; }
.form-input { width: 100%; padding: 16px 20px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; color: var(--foreground); font-size: 16px; font-family: 'Inter', sans-serif; }
.form-input:focus, textarea.form-input:focus { outline: none; border-color: rgba(139,92,246,0.5); background: rgba(255,255,255,0.05); }
textarea.form-input { resize: vertical; min-height: 120px; }
.auth-submit { width: 100%; padding: 18px 32px; background: var(--primary); color: var(--foreground); border: none; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; box-shadow: 0 8px 24px rgba(139,92,246,0.3); }
.auth-submit:hover { background: rgba(139,92,246,0.9); transform: translateY(-2px); }
.auth-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
.link-embed-ig iframe { max-width: 100%; border-radius: 16px; }
</style>
<?php
$extra_js = '<script src="assets/js/enquiry.js"></script>';
require_once __DIR__ . '/includes/footer.php';
?>
