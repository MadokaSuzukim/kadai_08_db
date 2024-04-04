<!-- 日記作成画面 -->
<?php
// データベース接続
try {
    $pdo = new PDO('mysql:dbname=gs_daily_db;charset=utf8;host=localhost', 'root', '');
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
</head>
<body>

<header>
  <!-- ヘッダーコンテンツ -->
</header>

<main>
  <div class="container">
    <h2><?= htmlspecialchars($nickname, ENT_QUOTES) ?>ちゃん、今日はどんな様子だった？</h2>
    <form method="POST" action="funcs.php" enctype="multipart/form-data">
      <input type="hidden" name="child_id" value="<?= htmlspecialchars($id, ENT_QUOTES) ?>">
      <label>日付：<input type="date" name="entry_date" required></label><br>
      <label>時間：<input type="time" name="entry_time" required></label><br>
      <label>今日の様子：<textarea name="content" rows="4" cols="40" required></textarea></label><br>
      <label>写真：<input type="file" name="photo"></label><br>
      <input type="submit" value="送信">
    </form>
  </div>
</main>

</body>
</html>
