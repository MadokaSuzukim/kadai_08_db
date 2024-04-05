<!-- 日記作成画面 -->
<?php
// データベース接続
try {
    $pdo = new PDO('mysql:dbname=marumark_gs_kadai;charset=utf8;host=mysql646.db.sakura.ne.j', 'root', '');
} catch (PDOException $e) {
    exit('DB_CONNECT:' . $e->getMessage());
}

// 特定のお子様のIDをセット（セッションやGETリクエストから取得するなど）
$id = 1; // この例では仮に1とします

// 特定のお子様のニックネームを取得
$stmt = $pdo->prepare("SELECT nickname FROM children WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$child = $stmt->fetch(PDO::FETCH_ASSOC);
$nickname = $child['nickname'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>育児日記の入力</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
  <style>
    .navbar .container-fluid {
      display: flex;
      justify-content: center;
    }
    .navbar-header {
      float: none;
    }

    /* ここから追加のスタイル */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #f8f9fa;
    }
    h1 {
  text-align: center;
}
    .container {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      padding: 20px;
      max-width: 600px;
      margin: 20px auto;
    }
    form {
      display: flex;
      flex-direction: column;
    }
    input[type="date"],
    input[type="time"],
    input[type="file"],
    textarea,
    input[type="submit"] {
      margin: 10px 0;
    }
    label {
      margin-top: 20px;
      margin-bottom: 5px;
      font-weight: bold;
    }
    input[type="submit"] {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 10px;
      cursor: pointer;
      border-radius: 5px;
    }
    input[type="submit"]:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<header>
  <!-- ヘッダーコンテンツ -->
</header>

<main>
  <h1>今日も育児お疲れ様！</h1>
  <div class="container">
    <h2><?= htmlspecialchars($nickname, ENT_QUOTES) ?>ちゃんは、今日どんな様子だった？</h2>
    <form method="POST" action="funcs.php" enctype="multipart/form-data">
      <input type="hidden" name="child_id" value="<?= htmlspecialchars($id, ENT_QUOTES) ?>">
      <label>日付：<input type="date" name="entry_date" required></label><br>
      <!-- <label>時間：<input type="time" name="entry_time" required></label><br> -->
      <label>今日の様子：<textarea name="content" rows="4" cols="40" required></textarea></label><br>
      <label>写真：<input type="file" name="photo_path"></label><br>
      <input type="submit" value="送信">
    </form>
  </div>
</main>

</body>
</html>
