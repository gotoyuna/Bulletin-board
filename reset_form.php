<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>パスワードリセット</title>
<link rel="stylesheet" type="text/css" href="passwordresset.css">
</head>
<body>
<form action="reset.php" method="POST">
<div class="passwordresset">
<h1>Password Resset Page</h1>
<h2>Please enter a new password</h2>
<div class="token">
<input type="hidden" name="_csrf_token" value="<?= $_SESSION['_csrf_token']; ?>">
<p><input type="password" name="password" placeholder="Password"></p>
<p><input type="password" name="password_confirmation" placeholder="※Confirm Password"></p>
<p><input type="submit" name="submit" value="Resset!"></p>
</div>
</form>
<p><a href="board.php">Back to board!</a></p>
</div>
</body>
</html>
