<!-- 1 初回登録画面 -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
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
</style>
<nav class="navbar navbar-default">

</head>
<body>

<!-- Head[Start] -->
<header>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- <div class="navbar-header"> -->
      <a class="navbar-brand" href="select.php">初回登録画面</a>
    </div>
  </div>
</nav>

<!-- Head[End] -->

<!-- Main[Start] -->
<main>
  <div class="container">
    <h2>お子様の情報を登録してください</h2>
    <p>以下のフォームにお子様の情報を入力してください。</p>
    <form method="POST" action="insert.php">
      <div class="mb-3">
        <label for="name" class="form-label">名前：</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="mb-3">
        <label for="nickname" class="form-label">ニックネーム：</label>
        <input type="text" class="form-control" id="nickname" name="nickname" required>
      </div>
      <div class="mb-3">
        <label for="birthdate" class="form-label">生年月日：</label>
        <input type="date" class="form-control" id="birthdate" name="birthdate" required>
      </div>
      <div class="mb-3">
        <label for="gender" class="form-label">性別：</label>
        <select class="form-select" id="gender" name="gender">
          <option value="male">男性</option>
          <option value="female">女性</option>
          <option value="other">その他</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="likes" class="form-label">好きなこと：</label>
        <textarea class="form-control" id="likes" name="likes" rows="4"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">送信</button>
    </form>
  </div>
</main>

<!-- Main[End] -->

<div class="navbar-header"><a class="navbar-brand" href="count.php">登録データ一覧参照</a></div>
</body>
</html>
