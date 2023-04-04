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
if (isset($_POST['upload'])) {
    if (!empty($_FILES['image_path']['tmp_name'])) {
        if (exif_imagetype($_FILES['image_path']['tmp_name'])) {
                $image_type = exif_imagetype($_FILES['image_path']['tmp_name']);
                switch($image_type) {
                  case IMAGETYPE_GIF:
                    $type = '.gif';
                    break;
                  case IMAGETYPE_JPEG:
                    $type = '.jpg';
                    break;
                  case IMAGETYPE_PNG:
                    $type = '.png';
                    break;
                  default:
                    $answer = 'This file dose not have a valid extension.';
                    exit;
                }
                $randam = uniqid(mt_rand(), true);
                $image_path = 'images/' . $randam . $type;
                move_uploaded_file($_FILES['image_path']['tmp_name'], $image_path);
        } else {
             $answer = 'Sorry, this is not image file.';
        }
    } else {
         $image_path = null;
    }
    if ($_POST['message'] === '') {
         $_POST['message'] = null;
    } 
    $sql_select = 'SELECT image_path FROM members WHERE id = :id';
    $stmt = $dbh->prepare($sql_select); 
    $stmt->bindValue('id', $_SESSION['member_id'], PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetch();
    if (!empty($res['image_path'])) {
         unlink($res['image_path']);
    }    
    if (!isset($answer)) {
         $sql = 'UPDATE members SET image_path = :image_path, message = :message WHERE id = :id';
         $stmt = $dbh->prepare($sql);
         $stmt->bindValue('image_path', $image_path);
         $stmt->bindValue('message', $_POST['message']);
         $stmt->bindValue('id', $_SESSION['member_id']);
         $stmt->execute();
         $answer = 'The upload is completed!!!';
         $dbh = null;
    } 
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>アップロード完了画面</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="message">
<h1><?php echo $answer; ?></h1>
<p><a href="board.php">Back to board</a></p>
<p><a href="userpage.php?board_id=<?php echo $_SESSION['board_id']; ?>">Back to profile edit page</a></p>
<div>
</body>
</html>
