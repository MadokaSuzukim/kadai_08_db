<!-- 日記登録画面 -->
<?php
// データベース接続
try {
    $pdo = new PDO('mysql:dbname=gs_daily_db;charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {
    exit('DB_CONNECT:' . $e->getMessage());
}

// POSTデータ取得
$entryDate = $_POST['entry_date'];
$entryTime = $_POST['entry_time'];
$content = $_POST['content'];
$photo = $_FILES['photo'];

// 写真のアップロード処理（例として、写真を "uploads" ディレクトリに保存）
$uploadDir = 'uploads/';
$uploadFile = $uploadDir . basename($photo['name']);
if (move_uploaded_file($photo['tmp_name'], $uploadFile)) {
    echo "ファイルは正常にアップロードされました。\n";
} else {
    echo "ファイルのアップロードに失敗しました。\n";
}

// データ登録SQL作成
$sql = "INSERT INTO diary_entries (child_id, entry_date, entry_time, content, photo_path) VALUES (1, :entry_date, :entry_time, :content, :photo_path)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':entry_date', $entryDate);
$stmt->bindValue(':entry_time', $entryTime);
$stmt->bindValue(':content', $content);
$stmt->bindValue(':photo_path', $uploadFile);

$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("SQL_ERROR:" . $error[2]);
} else {
    header("Location: diary_list.php"); // 日記一覧ページへリダイレクト
}
?>