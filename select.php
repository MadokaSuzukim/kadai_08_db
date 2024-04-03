<!-- 3 DB表示画面　 -->
<?php
//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_daily_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DB_CONECT:'.$e->getMessage());
}

//２．データ登録SQL作成
$sql = "SELECT * FROM children";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
// $view="";
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQL ERROR:".$error[2]);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
//JSONい値を渡す場合に使う
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>こども情報表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}
td{border: 1px solid red ;}
</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->


<!-- Main[Start] -->
<div>
    <div class="container jumbotron">
    <table>
      <tr>
        <th>ID</th>
        <th>名前</th>
        <th>ニックネーム</th>
        <th>生年月日</th>
        <th>性別</th>
        <th>好きなこと</th>
      </tr>
<?php foreach($values as $value){ ?>
    <tr>
  <td><?=$value["id"]?></td>
  <td><?=$value["name"]?></td>
  <td><?=$value["nickname"]?></td>
  <td><?=$value["birthdate"]?></td>
  <td><?=$value["gender"]?></td>
  <td><?=$value["likes"]?></td>
  </tr>
  
 <?php } ?>
 </table>
    </div>
</div>
<!-- Main[End] -->


<script>
  //JSON受け取り
  // const json = JSON.parse($a);
  // console.log(Object)
  const jsonStr = '<?=$json?>';
  const data = JSON.parse(jsonStr);
  console.log(data);
</script>
</body>
</html>
