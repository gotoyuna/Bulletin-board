<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>パスワード再発行画面</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="message">
<form action="sendmail.php" method="post">
<h1>Password reissue screen</h1>
<input type="hidden" name="_csrf_token" value="<?= $_SESSION['_csrf_token']; ?>">
<p>Please enter your e-mail address.</p>
<p>mail：<input type="mail" name="mail" value=''></p>
<p><input type="submit" name="submit" value="send"></p>
</form>
<p><a href="login.php">Back to Login page!</a></p>
</div>
</body>
</html>
