<?php
// setLanguage.php - set the language preference and redirect back
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$allowed = ['en', 'bn'];
$lang = isset($_GET['lang']) ? $_GET['lang'] : null;
if ($lang && in_array($lang, $allowed)) {
    $_SESSION['lang'] = $lang;
}

$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
// avoid open redirect: only redirect within the site
$parsed = parse_url($redirect);
if (isset($parsed['host']) && $parsed['host'] !== $_SERVER['HTTP_HOST']) {
    $redirect = 'index.php';
}

header('Location: ' . $redirect);
exit;
