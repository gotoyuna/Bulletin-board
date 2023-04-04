<?php
session_start();
try {
    $username = 'xs12470_phpuser';
    $pass = 'peppe1247';
    $dsn = 'mysql:host=localhost;dbname=xs12470_php;charset=utf8';
    $dbh = new PDO($dsn, $username, $pass);
} catch (PDOException $e) {
    echo '接続失敗' . $e->getMessage() . '\n';
}
$passwordResetToken = filter_input(INPUT_GET, 'token');
$_SESSION['passwordResetToken'] = $passwordResetToken;
$sql = 'SELECT * FROM members WHERE token = :token';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':token', $passwordResetToken, PDO::PARAM_STR);
$stmt->execute();
$passwordResetuser = $stmt->fetch();
if ($passwordResetuser) {
    $_SESSION['Resetmemberid'] = $passwordResetuser['id'];
}
if (!$passwordResetuser) {
    exit('無効なURLです');
    $tokenValidPeriod = (new DateTime())->modify('-30 minutes')->format('Y-m-d H:i:s');
}
if ($passwordResetuser['token_sent_at'] < $tokenValidPeriod) {
    exit('有効期限切れです');
}
if (empty($_SESSION['passwordResetToken'])) {
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
}
header('Location: reset_form.php');
?>
