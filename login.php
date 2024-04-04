<!-- login.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>
    <h2>ログイン</h2>
    <form action="login_process.php" method="POST">
        ユーザー名: <input type="text" name="username" required><br>
        パスワード: <input type="password" name="password" required><br>
        <input type="submit" value="ログイン">
    </form>
</body>
</html>
<?php
session_start(); // セッションの開始

// データベース接続
try {
    $pdo = new PDO('mysql:dbname=gs_daily_db;charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {
    exit('DB_CONNECT:' . $e->getMessage());
}

// ログインフォームからのデータ取得
$username = $_POST['username'];
$password = $_POST['password'];

// ユーザー認証（ここでは簡易的な認証を想定）
$stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username AND password = :password");
$stmt->bindValue(':username', $username);
$stmt->bindValue(':password', $password);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // ユーザーに紐づく子どものIDを取得（例としてusersテーブルにchild_idがあると仮定）
    $_SESSION['child_id'] = $user['id']; // 子どものIDをセッションに保存
    header("Location: diary_create.php"); // 日記作成ページへリダイレクト
} else {
    echo "ログインに失敗しました。";
}
?>
<!-- 日記登録画面 -->
<?php
session_start(); // セッションを開始
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
// 写真のアップロード処理
if ($photo['error'] === UPLOAD_ERR_OK) {
    // ファイル名にランダムな要素を追加
    $baseName = basename($photo['name']);
    $uniqueName = uniqid() . "_" . $baseName; // 一意なファイル名を生成
    $uploadFile = $uploadDir . $uniqueName;

    if (move_uploaded_file($photo['tmp_name'], $uploadFile)) {
        echo "ファイルは正常にアップロードされました。\n";
    } else {
        echo "ファイルのアップロードに失敗しました。\n";
    }
} else {
    echo "ファイルのアップロードに失敗しました。\n";
}
// セッションから子どものIDを取得
$id = $_SESSION['child_id'];

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