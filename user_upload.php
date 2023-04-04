<?php
  session_start();
  try {
      $username = 'xs12470_phpuser';
      $pass = 'peppe1247';
      $dsn = 'mysql:host=localhost;dbname=xs12470_php;charset=utf8';
      $dbh = new PDO($dsn, $username, $pass);
  } catch (PDOException $e) {
      echo '接続失敗' . $e->getMessage() . '\n';
      exit();
  }
  $sql = 'SELECT board.id, member_id FROM board INNER JOIN members ON board.member_id = members.id';
  $stmt = $dbh->query($sql);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>edituserpage</title>
<link href="user.css" rel="stylesheet" type="text/css">
</head>
<body class="wrap">
<div class ="content">
<h1>Profile edit page</h1>
<form method="post" enctype="multipart/form-data" action="user_edit.php">
<h2>image</h2>
<input type="file" name="image_path"></br>
<h3>Message</h3>
<textarea name="message"><?php echo $_GET['message']; ?></textarea></br>
<input type="submit" name="upload" value="upload"></br>
<p><a href="userpage.php?board_id=<?php echo $_SESSION['board_id']; ?>">Back to profilepage</a></p>
</form>
</div>
</body>
</html>
