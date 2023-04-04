<?php
session_start();
$request = filter_input_array(INPUT_POST);
if (empty($request['_csrf_token']) || empty($_SESSION['_csrf_token']) || $request['_csrf_token'] !== $_SESSION['_csrf_token']) {

}
$error_message = array();
if (empty($_POST['password'])) {
    $error_message[] = 'Please enter your password.';
} elseif (!preg_match('/\A[a-z\d]{8,15}+\z/i', $_POST['password'])) {
    $error_message[] = 'The password format is incorrect.';
}
if (empty($_POST['password_confirmation'])) {
    $error_message[] =  'Please enter the password for confirmation.';
} elseif (!preg_match('/\A[a-z\d]{8,15}+\z/i', $_POST['password_confirmation'])) {
   $error_message[] =  'The confirmation password format is incorrect.';
}
if(!empty($_POST['password']) && !empty($_POST['password_confirmation']) && $_POST['password'] !== $_POST['password_confirmation']) {
    $error_message[] = 'Passwords do not match.';
}
try {
    $username = 'xs12470_phpuser';
    $pass = 'peppe1247';
    $dsn = 'mysql:host=localhost;dbname=xs12470_php;charset=utf8';
    $dbh = new PDO($dsn, $username, $pass);
} catch (PDOException $e) {
    echo '接続失敗' . $e->getMessage() . '\n';
}
$sql = 'UPDATE members SET pass = :pass WHERE id = :passwordResetuser';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':pass', $request['password'], PDO::PARAM_STR);
$stmt->bindValue(':passwordResetuser', $_SESSION['Resetmemberid'], PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->execute();
$answer = 'You have successfully changed your password!!!';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>pasuwordエラーメッセージ表示</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="message">
<?php if (!empty($error_message)): ?>
<?php foreach( $error_message as $value ): ?>
<h1><?php echo $value; ?></h1>
<?php endforeach; ?>
<a href="reset_form.php">Back to Password Resset Page</a>
<?php else : ?>
<h1><?php echo $answer; ?></h1>
<a href="board.php">Back to board</a>
<?php endif; ?>
</div>
</body>
</html>
