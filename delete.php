<?php
session_start();
if (isset($_GET['board_id'])) {
    try {
        $username = 'xs12470_phpuser';
        $pass = 'peppe1247';
        $dsn = 'mysql:host=localhost;dbname=xs12470_php;charset=utf8';
        $dbh = new PDO($dsn, $username, $pass);
    } catch (PDOException $e) {
        echo '接続失敗' . $e->getMessage() . '\n';
        exit();
    }
    $select_sql = 'select member_id from board where id = :board_id';
    $select_stmt = $dbh->prepare($select_sql);
    $select_stmt->bindParam(':board_id', $_GET['board_id'], PDO::PARAM_INT);
    $select_stmt->execute();
    if ($select_result = $select_stmt->fetch()) {
        if (isset($select_result) && $_SESSION['member_id'] === $select_result['member_id']) {
                $sql = 'UPDATE board SET deleted_at = now() WHERE id = :board_id';
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':board_id', $_GET['board_id'], PDO::PARAM_INT);
                if ($stmt->execute()) {
                    header('Location: board.php');
                    return;
                }
        }
    }
    header('Location: board.php');
}
$dbh = null;
?>
