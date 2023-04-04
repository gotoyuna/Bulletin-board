<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>投稿の編集</title>
<link rel="stylesheet" href="newpost.css">
</head>
<body>
<form method="POST" action="edit_session.php">
<div class="container">
<div class="head">
<h2>Edit comment</h2>
</div>
<input type="text" name="title" placeholder="Title" value="<?php if (!empty($_GET['title']) ){ echo $_GET['title']; } ?>"><br />
<textarea type="text" name="text" placeholder="Text"><?php if(!empty($_GET['text'])) { echo $_GET['text']; } ?></textarea><br />
<div class="message">Message Sent</div>
<input type="hidden" name="board_id" value="<?php if (!empty($_GET['board_id']) ){ echo $_GET['board_id']; } ?>">
<button id="submit" type="submit" name="btn_submit" value="Uploard">
Uploard!
</button>
</form>
<p><a href="board.php">Back to board!</a>
</div>
</body>
</html>
