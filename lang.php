<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// default language
if (isset($_GET['lang'])) {
    $langParam = $_GET['lang'];
    if (in_array($langParam, ['en', 'bn'])) {
        $_SESSION['lang'] = $langParam;
    }
}

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

$lang = [];
// load language file
if ($_SESSION['lang'] === 'bn' && file_exists(__DIR__ . '/lang/bn.php')) {
    $lang = include __DIR__ . '/lang/bn.php';
} elseif (file_exists(__DIR__ . '/lang/en.php')) {
    $lang = include __DIR__ . '/lang/en.php';
}

function t($key)
{
    global $lang;
    return isset($lang[$key]) ? $lang[$key] : $key;
}

?>
