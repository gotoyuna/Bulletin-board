<?php
session_start();
date_default_timezone_set('Asia/Tokyo');
$mail = filter_input(INPUT_POST, 'mail');
if (isset($_POST['submit']) && isset($_POST['mail'])) {
    $mail = $_POST['mail'];
    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        try {
            $username = 'xs12470_phpuser';
            $pass = 'peppe1247';
            $dsn = 'mysql:host=localhost;dbname=xs12470_php;charset=utf8';
            $dbh = new PDO($dsn, $username, $pass);
        } catch (PDOException $e) {
            echo '接続失敗' . $e->getMessage() . '\n';
        }
        $sql = 'SELECT mail FROM members WHERE mail = :mail';
        $exists_mail_stmt = $dbh->prepare($sql);
        $exists_mail_stmt->bindValue(':mail', $mail);
        $exists_mail_stmt->execute();
        $exists_mail = $exists_mail_stmt->fetch();
        if (!$exists_mail) {
            $sql = 'INSERT INTO members(mail, token, token_sent_at) VALUES(:mail, :token, :token_sent_at)';
        } else {
            $sql = 'UPDATE members SET token = :token, token_sent_at = :token_sent_at WHERE mail = :mail';
        }
        $passwordResetToken = bin2hex(random_bytes(32));
        $url = 'https://yuna-create.com/board/show_reset_form.php?token=' . $passwordResetToken;
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
            $stmt->bindValue(':token', $passwordResetToken, PDO::PARAM_STR);
            $stmt->bindValue(':token_sent_at', (new DateTime())->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->execute();
            mb_language('Japanese');
            mb_internal_encoding('UTF-8');
            $title = 'パスワード再発行';
            $content = 'パスワード再発行URLは以下の通りです。30分のみ有効です' .$url;
            $headers = 'From: example@from.com';
            mb_send_mail($mail, $title, $content, $headers);
            $reset_date = date('Y-m-d H:i:s');
        } catch (Exception $e) {
            exit($e->getMessage());
        } 
        $msg = 'A reissue URL has been sent to your email address.';
    } else {
        $msg = 'Please enter your registered email address.';
    } 
}
?>
<!DOCTYPE html> 
<html lang="ja"> 
<head>
<meta charset="UTF-8">
<title>パスワードリセット</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head> 
<body>
<div class="message">
<h1><?php
bin2hex(random_bytes(32));
if (isset($_POST['submit']) && isset($mail)) :
    echo $msg;
else :
?></h1>
<?php endif; ?>
<p><a href="reissue.php">Back to password reissue screen</a></p>
</div>
</body>
</html>
