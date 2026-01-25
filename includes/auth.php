<?php
/**
 * Admin auth helpers.
 * Call session_start() before using.
 */

function is_admin_logged_in() {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

function require_admin() {
    if (!is_admin_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function get_admin_id() {
    return isset($_SESSION['admin_id']) ? (int) $_SESSION['admin_id'] : 0;
}
