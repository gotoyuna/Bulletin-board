<?php
session_start();
if (isset($_POST['name']) && isset($_POST['mail']) && isset($_POST['pass'])) {
   $name = $_POST['name'];
   $mail = $_POST['mail'];
   $password = $_POST['pass'];
   if ($name == '' || $mail == '' || $password == '') {
      $answer = 'Please enter all of the items.';
   } elseif (!filter_var($mail,  FILTER_VALIDATE_EMAIL)) {
         $answer = 'The email address format is incorrect.';
   } elseif (!preg_match('/\A[a-z\d]{8,15}+\z/i', $password)) {
         $answer = 'Please enter a password with 8 to 15 half-width alphanumeric characters.';
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
      $sql = 'SELECT * FROM members WHERE mail = :mail';
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(':mail', $mail);
      $stmt->execute();
      if ($result = $stmt->fetch()) {
         $answer = 'This email address has already been registered.';
         $_SESSION['mail'] = $result['mail'];
      } else {
           $sql = 'INSERT INTO members (name, mail, pass) VALUES (:name, :mail, :pass)';
           $stmt = $dbh->prepare($sql);
           $params = array(':name' => $name, ':mail' => $mail, ':pass' => $password);
           $kekka = $stmt->execute($params);
           $answer = 'Membership registration is complete!!';
      }
   }
   $dbh = null;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>会員登録エラーメッセージ表示</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="message">
<h1><?php echo $answer; ?></h1>
<p><a href=login.php>Go to Login page!</a></p>
<p><a href="register.php">Registration page!</a></p>
</div>
</body>
</html>
