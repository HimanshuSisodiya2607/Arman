<?php
/**
 * Delete link by ID. Redirects to dashboard.
 */
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_admin();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id > 0) {
    $stmt = $pdo->prepare('DELETE FROM links WHERE id = ?');
    $stmt->execute([$id]);
}
header('Location: dashboard.php');
exit;
