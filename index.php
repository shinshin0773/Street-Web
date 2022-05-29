<?php
  define("CHAT", "chat.txt");
  session_start();

  // もし送信ボタンが押されたら（issetは変数に値があるという意味
  if(isset($_POST['datapost'])){
    $_SESSION['name'] = $_POST['name'];
    // 受け取った名前をセッションに保存して、regist.phpへ移動
    // header('Location:');
  }

  // date_default_timezone_set('Asia/Tokyo');

  // if($_SERVER["REQUEST_METHOD"] === "POST"){
  //   $text = $_POST['message'] . "," . date('m月d日 H時i分s秒') . "\n";
  //   file_put_contents(CHAT, $text, FILE_APPEND);
  // }

  //regist.phpの処理 データベースに保存する処理
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



  try {
    $pdo = new PDO('mysql:host=localhost;dbname=test;charset=utf8','root','root');
    // echo "接続OK!";
  } catch (PDDException $e) {
    exit('データベース接続失敗。'.$e -> getMessage());
  }


  // データの数を調べる
  $sql = "SELECT * FROM name";
  // SQLの実行
  $query = $pdo->query($sql);
  $sth = $pdo -> query($sql);
  $count = $sth -> rowCount();
  // echo $count.'件SELECTしました。';

  //全件取得する
  $articles = $query->fetchAll(PDO::FETCH_BOTH);

  //var_dumpは$articlesの中身を見る
  // var_dump($articles);
  $json_array = json_encode($articles);

  // $id = 7;

  // $stmt = $pdo -> prepare("SELECT * FROM name WHERE id=:id"); //SQL文nameの中のid=1を取り出す
  // $stmt -> bindValue(':id', $id, PDO::PARAM_INT);
  // $stmt -> execute(); //データの取り出しを実行
  // $data = $stmt -> fetch(); //$dataに取り出した内容を配列として格納
  $pdo = NULL;
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="uth-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>簡易チャット</title>
    <style type="text/css">
      *{margin: 0;padding: 0;list-style: none;}
      .top-wrap {
        width: 820px;
      }
      .wrap{
        margin: 0 auto;
        padding: 20px 0 100px 0;
        background: #f1f1f2;
        width: 100vw;
        height: 100vh;
      }
      ul {
        list-style: none;
      }
      .listClass {
        position: relative;
        padding: 10px 20px;
        margin: 0 10px 10px 10px;
        background-color: #fff;
        border-radius: 5px;
      }
      span {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 10px;
        font-size: 12px;
        color: #ccc;
      }
      form{
        position: fixed;
        top: 80%;
        left: 40%;
      }
      .header-wrap {
        display: flex;
        background-color: rgba(82,82,82,1);
      }
      .header-h1 {
        margin: 0 auto;
        color: #EEEEEE;
      }
      .header-ul {
        display: flex;
        margin: 15px;
        color: #EEEEEE;
      }
      .header-li {
        margin-right:15px;
      }
      .ListDiv {
        display: flex;
        flex-wrap: wrap;
      }
    </style>
  </head>
  <body>
    <div class="top-wrap">
      <header>
        <div class="header-wrap">
          <div class="header-h1">
            <h1>Street</h1>
          </div>
          <ul class="header-ul">
            <li class="header-li">探す</li>
            <li>お気に入り</li>
          </ul>
        </div>
      </header>
      <div class="wrap">
        <ul class="ItemUl">
          <div class="ItemDiv">
            <ul id="result">

            </ul>
          </div>
        </ul>
      </div>

      <form action="index.php" method="post">
          <!-- <input type="text" name="message"> -->
          <input type="text" name="name">
          <input type="submit" name="datapost">
      </form>
      <a href="view.php">掲示板を表示</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <script>
      // $(function() {
      //   $.ajax({
      //     url: 'chat.txt',
      //   })
      //   .done(function(data) {
      //     data.split('\n').forEach(function(chat) {
      //       const post_text = chat.split(',')[0];
      //       const post_time = chat.split(',')[1];
      //       if(post_text) {
      //         const li = `<li class="listClass">${post_text}<span>${post_time}</span></li>`;
      //         $('.ListDiv').append(li)
      //       }
      //     });
      //   });
      // });

      //PHPのjsonfileに入れたオブジェクトからJqueryで表示
      $(function() {
        const js_array = JSON.parse('<?php echo $json_array; ?>');
        console.log(js_array);

        $.each(js_array, function(index,value){
          $('#result').append('<li>' + value.name + '</li>');
          console.log(value.name);
        })
      });
    </script>
  </body>
</html>
