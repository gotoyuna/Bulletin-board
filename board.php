<?php
session_start();
$username = 'xs12470_phpuser';
$pass = 'peppe1247';
$dsn = 'mysql:host=localhost;dbname=xs12470_php;charset=utf8';
try {
    $dbh = new PDO($dsn, $username, $pass);
} catch (PDOException $e) {
    echo '接続失敗' . $e->getMessage() . '\n';
}
$sql = 'SELECT board.id, member_id, title, text, datetime, name  FROM board INNER JOIN members ON board.member_id = members.id WHERE deleted_at is null';
$stmt = $dbh->query($sql);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>Bulletin board</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="heading">
<h1>Bulletin board</h1>
</div>
<table>
<thead>
<tr>
<th>No</th>
<th>Name</th>
<th>Title</th>
<th>Text</th>
<th>Datetime</th>
<th>Operations</th>
</tr>
</thead>
<tbody>
<?php while ($result = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
<tr>
<td><?php echo $result['id']; ?></td>
<td><a href="userpage.php?board_id=<?php echo $result['id']; ?>" class="name"><?php echo $result['name']; ?></a></td>
<td><?php echo $result['title']; ?></td>
<td><?php echo $result['text']; ?></td>
<td><?php echo $result['datetime']; ?></td>
<?php if (isset($_SESSION['member_id']) && $_SESSION['member_id'] === $result['member_id']): ?>
<td class="operations">
<a href="edit.php?board_id=<?php echo $result['id']; ?>&title=<?php echo $result['title']; ?>&text=<?php echo $result['text']; ?>" class="btn-upload">upload</a>
<a href="delete.php?board_id=<?php echo $result['id']; ?>" class="btn-delete">delete</a>
</td>
<?php endif; ?>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<div class="info">
<?php if (isset($_SESSION['mail']) && isset($_SESSION['password'])): ?>
<p><a href="logout.php">Logout</a></p>
<?php else: ?>
<p><a href="register.php">Register a membership</a></p>
<p><a href="login.php">Login</a></p>
<?php endif; ?>
<?php if (isset($_SESSION['mail']) && isset($_SESSION['password'])): ?>
<p><a href="newpost.php">Let's new post!</a></p>
<?php else: ?>
<p><a href="login.php">Let's new post!</a></p>
<?php endif; ?>
</div>
</body>
</html>
