<?php
session_start();
if (!isset($_SESSION['mail']) && !isset($_SESSION['pass'])) {
    header("Location: board.php");
    exit();
}
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', time() - 42000, '/');
}
session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログアウトページ</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="message">
<h1>Logged out successfully.</h1>
<a href="board.php">Back to board</a>
</div>
</body>
</html>
