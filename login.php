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
