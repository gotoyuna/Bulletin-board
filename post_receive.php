<?php
session_start();
if (isset($_POST['title']) && isset($_POST['text'])) {
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES);
    $text = htmlspecialchars($_POST['text'], ENT_QUOTES);
    if ($title == '' || $text == '') {
          $answer = 'Please enter both the title and text.';
    } else {
          try {
              $username = 'xs12470_phpuser';
              $pass = 'peppe1247';
              $dsn = 'mysql:host=localhost;dbname=xs12470_php;charset=utf8';
              $dbh = new PDO($dsn, $username, $pass);
              $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch (PDOException $e) {
              echo '接続失敗' . $e->getMessage() . '\n';
              exit();
          }
          $current_date = date('Y-m-d H:i:s');
          $sql = 'INSERT INTO board (member_id, title, text, datetime) VALUES (:member_id, :title, :text, :current_date)';
          $stmt = $dbh->prepare($sql);
          $stmt->bindParam(':member_id', $_SESSION['member_id'], PDO::PARAM_INT);
          $stmt->bindParam(':title', $title, PDO::PARAM_STR);
          $stmt->bindParam(':text', $text, PDO::PARAM_STR);
          $stmt->bindParam(':current_date', $current_date, PDO::PARAM_STR);
          $stmt->execute();
          /*$answer = '掲示板が投稿されました。';*/
          header('Location: board.php');
    }
    $dbh = null;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>投稿を受け取る</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="message">
<h1><?php echo $answer; ?></h1>
<p><a href="newpost.php">Back to post page</a>
<p><a href="board.php">Back to board</a>
</div>
</body>
</html>
