<?php
session_start();
$error_message = array();
if (isset($_POST['title']) && empty($_POST['title'])) {
    $error_message[] = 'Please enter a title.';
}
if (isset($_POST['text']) && empty($_POST['text'])) {
    $error_message[] = 'Please enter the text.';
}
if (isset($_POST['text']) && isset($_POST['title']) && isset($_SESSION['board_id']) && empty($error_message)) {    
    $username = 'xs12470_phpuser';
    $pass = 'peppe1247';
    $dsn = 'mysql:host=localhost;dbname=xs12470_php;charset=utf8';
    try {
         $dbh = new PDO($dsn, $username, $pass);
    } catch (PDOException $e) {
         echo '接続失敗' . $e->getMessage() . '\n';
    }
    $select_sql = 'select member_id from board where id = :board_id';
    $select_stmt = $dbh->prepare($select_sql);
    $select_stmt->bindParam(':board_id', $_SESSION['board_id'], PDO::PARAM_INT);
    $select_stmt->execute();
    if ($select_result = $select_stmt->fetch()) {
           if (isset($select_result) && $_SESSION['member_id'] === $select_result['member_id']) {
                  $sql = 'UPDATE board SET title = :title, text = :text WHERE id = :id';
                  $stmt = $dbh->prepare($sql);
                  $stmt->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
                  $stmt->bindParam(':text', $_POST['text'], PDO::PARAM_STR);
                  $stmt->bindParam(':id', $_SESSION['board_id'], PDO::PARAM_INT);
                  $stmt->execute();
                  if ($result = $stmt->execute()) {
                           $error_message[] = 'Your post has been edited!!!';
                  }
           } else {
               exit;
           }
    }
}
$dbh = null;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>編集された値を受け取る</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="message">
<?php if (!empty($error_message)): ?>
<?php foreach( $error_message as $value ): ?>
<h1><?php echo $value; ?></h1>
<?php endforeach; ?>
<?php endif; ?>
<p><a href="edit.php?title=<?php echo $_POST['title']; ?>&text=<?php echo $_POST['text']; ?>">Back to edit page</a></p>
<p><a href="board.php">Back to board</a></p>
</div>
</body>
</html>
