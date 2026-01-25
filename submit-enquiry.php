<?php
/**
 * AJAX endpoint: submit enquiry (name, email, message).
 * Expects POST; returns JSON.
 */
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

require_once __DIR__ . '/includes/db.php';

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$message = trim($_POST['message'] ?? '');

if (!$name || !$email || !$message) {
    echo json_encode(['ok' => false, 'error' => 'Name, email, and message are required.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['ok' => false, 'error' => 'Invalid email address.']);
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO enquiries (name, email, phone, message) VALUES (?, ?, ?, ?)');
    $stmt->execute([$name, $email, $phone ?: null, $message]);
} catch (PDOException $e) {
    echo json_encode(['ok' => false, 'error' => 'Could not save enquiry. Please try again.']);
    exit;
}

echo json_encode(['ok' => true, 'msg' => 'Thank you! Your enquiry has been sent.']);
