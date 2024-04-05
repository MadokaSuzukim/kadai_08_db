<!-- 2 データ処理画面 -->
<?php
//1. POSTデータ取得
//[name,email,age,naiyou]
$name   = $_POST["name"];
$nickname = $_POST["nickname"];
$birthdate  = $_POST["birthdate"];
$gender    = $_POST["gender"];
$likes = $_POST["likes"];

//2. DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=marumark_gs_kadai;charset=utf8;host=mysql57.db.sakura.ne.jp','root','');
} catch (PDOException $e) {
  exit('DB_CONNECT:'.$e->getMessage());
}

//３．データ登録SQL作成
$sql = "INSERT INTO children (name,nickname, birthdate,gender, likes,indate) VALUES (:name,:nickname, :birthdate,:gender, :likes,sysdate())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name',  $name,  PDO::PARAM_STR );  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':nickname', $nickname, PDO::PARAM_STR);
$stmt->bindValue(':birthdate', $birthdate,    PDO::PARAM_STR );  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':gender', $gender, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':likes', $likes, PDO::PARAM_STR); // 好きなことをバインド
$status = $stmt->execute();//true or false

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}else{
  //５．index.phpへリダイレクト
 header("Location: index.php");
 exit();

}
?>
