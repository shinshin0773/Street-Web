<?php
session_start();
try {
  $pdo = new PDO('mysql:host=localhost;dbname=test;charset=utf8','root','root');
  echo "接続OK!";
} catch (PDDException $e) {
  exit('データベース接続失敗。'.$e -> getMessage());
}

$name = $_SESSION['name'];//ユーザーから受け取った値を変数に入れる
$stmt = $pdo -> prepare("INSERT INTO name(name) VALUES(:name)");//登録準備
$stmt -> bindValue(':name', $name, PDO::PARAM_STR);//登録する文字の型を固定
$stmt -> execute();//データベースの登録を実行
$pdo = NULL;//データベース接続を解除

?>
