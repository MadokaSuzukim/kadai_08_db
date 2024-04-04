<?php
session_start(); // セッション開始

// データベース接続
try {
    $pdo = new PDO('mysql:dbname=gs_daily_db;charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {
    exit('DB_CONNECT:' . $e->getMessage());
}

// フォームから受け取ったユーザー名とパスワード
$username = $_POST['username'];
$password = $_POST['password'];

// ユーザー名とパスワードでユーザーを検索
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->bindValue(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // パスワードが一致した場合、セッションに子どものIDを保存
    $_SESSION['child_id'] = $user['child_id']; // usersテーブルにchild_idカラムが存在すると仮定

    // ログイン後にリダイレクトするページへ
    header('Location: diary_create.php');
    exit;
} else {
    // 認証失敗
    echo "ログインに失敗しました。";
    // ログインページに戻るなどの処理
}
?>
