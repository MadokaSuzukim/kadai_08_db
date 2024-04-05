<!-- 日記登録画面 -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // セッションを開始

// 1.POSTデータ取得
$date = $_POST['entry_date'];
$content = $_POST['content'];
$photo = $_FILES['photo_path'];


// 2.データベース接続
try {
    $pdo = new PDO('mysql:dbname=gs_daily_db;charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {
    exit('DB_CONNECT:' . $e->getMessage());
}



// 写真のアップロード処理（例として、写真を "uploads" ディレクトリに保存）
$uploadDir = 'uploads/';
$uploadFile = $uploadDir . uniqid() . "_" . basename($photo['name']); // 一意性を持たせたファイル名

if (move_uploaded_file($photo['tmp_name'], $uploadFile)) {
    echo "ファイルは正常にアップロードされました。\n";
} else {
    echo "ファイルのアップロードに失敗しました。\n";
    exit; // 追加
}

// // セッションから子どものIDを取得
$id = $_SESSION['child_id'];

// 3 データ登録SQL作成
$sql = "INSERT INTO diary_entries (child_id, date, content, photo_path) VALUES (:child_id, :date, :content, :photo_path)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':child_id', $id, PDO::PARAM_INT); // 修正
$stmt->bindValue(':date', $date);
$stmt->bindValue(':content', $content);
$stmt->bindValue(':photo_path', $uploadFile);
$status = $stmt->execute();

// 4.データ登録処理後
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("SQL_ERROR:" . $error[2]);
} else {
    header("Location: diary_list.php"); // 日記一覧ページへリダイレクト
}
?>