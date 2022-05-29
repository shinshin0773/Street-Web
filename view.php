<?php
// MySQLサーバへ接続するコード
session_start();
try {
  $pdo = new PDO('mysql:host=localhost;dbname=test;charset=utf8','root','root');
  echo "接続OK!";
} catch (PDDException $e) {
  exit('データベース接続失敗。'.$e -> getMessage());
}

// MySQL取り出すコード 1番目の名前を取り出す
$id = 7;
$stmt = $pdo -> prepare("SELECT * FROM name WHERE id=:id"); //SQL文nameの中のid=1を取り出す
$stmt -> bindValue(':id', $id, PDO::PARAM_INT);
$stmt -> execute(); //データの取り出しを実行
$data = $stmt -> fetch(); //$dataに取り出した内容を配列として格納
$pdo = NULL;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
  <div class="top-wrap">
  <div class="wrap">
    <ul class="Ulclass">
      <div class="ListDiv">
        <h1>名前表示</h1>
        <p>通し番号: <?php echo $data['id']; ?></p>
        <p>お名前:<?php echo $data['name']; ?> </p>
      </div>
    </ul>
  </div>
</body>
</html>
