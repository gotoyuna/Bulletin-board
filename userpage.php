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
$_SESSION['board_id'] = $_GET['board_id'];
$user_sql = 'SELECT board.id, message, image_path, name, mail, members.id as member_id FROM board INNER JOIN members ON board.member_id = members.id WHERE board.id = :board_id';
$stmt = $dbh->prepare($user_sql);
$stmt->bindValue(':board_id', $_SESSION['board_id'], PDO::PARAM_INT);
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>userpage</title>
<link href="user.css" rel="stylesheet" type="text/css">
</head>
<body class="wrap">
<div class="content">
<h1>Profile</h1>
<figure class="profile-image">
<?php if ($value = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
<?php if (empty($value['image_path'])): ?>
<p>画像未登録<p>
<?php else: ?>
<p><img src="<?php echo $value['image_path']; ?>"width="300" height="300"></p>
<?php endif; ?>
</figure>
<h2><?php echo $value['name']; ?></h2>
<p>Mail: <?php echo $value['mail']; ?></p>
<h3>Message</h3>
<p><?php echo $value['message']; ?></p>
<?php endif; ?>
<?php if (isset($_SESSION['member_id']) && $_SESSION['member_id'] == $value['member_id']): ?>
<p><a href="user_upload.php?message=<?php echo $value['message']; ?>&image_path=<?php echo $value['image_path']; ?>">Edit</a></p>
<?php endif;?>
<p><a href="board.php">Back to board</a></p>
</div>
</body> 
</html>
