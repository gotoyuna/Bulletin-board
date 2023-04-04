<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログインページ</title>
<link rel="stylesheet" href="login.css">
</head>
<body>
<form method="post" action="loginsession.php">
<div class="login">
<div class="login-triangle"></div>
<h2 class="login-header">Login page</h2>
<form class="login-container">
<p><input type="text" name="mail" placeholder="Email"></p>
<p><input type="password" name="password" placeholder="Password"></p>
<p><input type="submit" name="submit" value="Login"></p>
</form>
<p><a href="reissue.php">If you forgot your password, click here</a></p>
<p><a href="register.php">Register a membership</a></p>
<p><a href="board.php">Back to board!</a></p>
</div>
</body>
</html>
