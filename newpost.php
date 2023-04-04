<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>新規投稿画面</title>
<link rel="stylesheet" href="newpost.css">
</head>
<body>
<form id="contact" method="post" action="post_receive.php">
<div class="container">
<div class="head">
<h2>Say Hello</h2>
</div>
<input type="text" name="title" placeholder="Title" /><br />
<textarea type="text" name="text" placeholder="Text"></textarea><br />
<div class="message">Message Sent</div>
<button id="submit" type="submit" name="btn_submit" value="send">
Send!
</button>
</form>
<p><a href="board.php">Back to board!</a>
</div>
</body>
</html>
