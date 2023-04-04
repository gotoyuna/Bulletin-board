<?php
session_start();
if (isset($_POST['mail']) && isset($_POST['password'])) {
       $mail = $_POST['mail'];
       $password = $_POST['password'];
       if ($mail == '' && $password == '') {
	      $answer = 'Sorry, please enter your email and password.';
       } elseif ($mail == '') {
	      $answer = 'Sorry, please enter your email address.';
       } elseif (!filter_var($mail,  FILTER_VALIDATE_EMAIL)) {
	      $answer = 'Sorry, the email address format is incorrect.';
       } elseif ($password == '') {
	      $answer = 'Sprry, please enter your password.';
       } elseif (!preg_match('/\A[a-z\d]{8,15}+\z/i', $password)) {
	      $answer = 'Sorry, please enter the password in half-width alphanumeric characters.';   
       } else {
              try {
                  $username = 'xs12470_phpuser';
                  $pass = 'peppe1247';
                  $dsn = 'mysql:host=localhost;dbname=xs12470_php;charset=utf8';
                  $dbh = new PDO($dsn, $username, $pass);
              } catch (PDOException $e) {
                      echo '接続失敗' . $e->getMessage() . '\n';
                      exit();
              }
              $sql = 'SELECT * FROM members WHERE mail = :mail AND pass = :pass';
              $stmt = $dbh->prepare($sql);
              $stmt->bindValue(':mail', $mail);
              $stmt->bindValue(':pass', $password);
              $stmt->execute();
              if ($result = $stmt->fetch()) {
                     $_SESSION['mail'] = $result['mail'];
                     $_SESSION['password'] = $result['pass'];
                     $_SESSION['member_id'] = $result['id'];
                     header('Location: board.php');
                     return;
              } else {
                   $answer = 'Sorry, Member does not exist.';
              }
       }
       $dbh = null;
} else {
     $answer = 'Sorry, there is a problem with your input.';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログインエラー文表示</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="message">
<h1><?php echo $answer; ?></h1>
<p><a href="login.php">Back to Login page</a></p>
<p><a href="board.php">Back to board</a></p>
</div>
</body>
</html>
