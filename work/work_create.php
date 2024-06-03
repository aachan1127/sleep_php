<?php
// var_dump($_POST);
// exit();

// ーーーーーーー入力チェックーーーーーーーーー
// DBにデータを格納する場合、基本的にデータの欠損は許されない！（データなしを許可する設定もある）
//①必須項目のデータが送信されていない
//②必須項目が空で送信されている  この①と②のふたつを設定する。

if (
    !isset($_POST['sleep_start_time']) || $_POST['sleep_start_time'] === '' ||
    !isset($_POST['sleep_end_time']) || $_POST['sleep_end_time'] === ''||
    !isset($_POST['feel']) || $_POST['feel'] === ''||
    !isset($_POST['comment']) || $_POST['comment'] === ''
  ) {
    //エラーメッセージを表示させる
    exit('必須項目が入力されていません');
  }
  

// ーーーーーーーPOSTで送信されたデータの受け取りーーーーーーーーーーーーーー
// メソッドがPOSTで送信されているので、$_POSTで受け取る。GETの時はGET
// $の後ろはinputのnameで指定したキー名、[]の中は　PHPMyAdminで指定したカラム名を入れる

// $************ = $_POST["*************"];日付追加する？

$sleep_start_time = $_POST["sleep_start_time"];
$sleep_end_time   = $_POST["sleep_end_time"];
$feel             = $_POST["feel"];
$comment          = $_POST["comment"];


// ーーーーーーーーDB接続ーーーーーーーーーーーー
// ここの項目はこういうもんだと思ってそのままコピーする

// 各種項目設定 mysqlのデータベース名の名前は　phpMyAdminのファイル名に変更する
$dbn ='mysql:dbname=gs_l10_02_work_php02;charset=utf8mb4;port=3306;host=localhost';
// #######    さくらサーバーなどに上げるときはここを さくらのid名に変更する！　ザンプを使用している場合はrootでOK！
$user = 'root'; 
// #######    さくらサーバーに上げる時はここを さくらのパスワードに変更する！　ザンプを使用している場合は何も記入しなくてOK！まんぷの場合はroot
$pwd = '';

try {
    $pdo = new PDO($dbn, $user, $pwd);
  } catch (PDOException $e) {
    // DB接続でエラーが出ている場合は、ここのエラーメッセージが表示される。
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
  }

// ーーーーーーーーーーSQL作成&実行ーーーーーーーーーーーー
// ここの項目も毎回一緒なので、こういうもんだと思って　OK ！
// .sqlファイルで作ったインサート文を元にコピーして、VALUESの後ろを、カラム名に変更する。※カラム名の前に : をつけるのを忘れない！（バインド変数）

$sql = 'INSERT INTO sleep_table (id, sleep_start_time, sleep_end_time, feel, comment, created_at, updated_at) VALUES(NULL, :sleep_start_time, :sleep_end_time, :feel, :comment, now(), now())';
// 上の　DB接続で作った　$pdoの変数を使って sqlを送信する
$stmt = $pdo->prepare($sql);

// ーーーーーーーーーーバインド変数を設定ーーーーーーーーーーー　ハッキング防止　！！！
// bindValue　の中身は　:カラム名　$　　　PDO::PARAM_STR　のところはカラムの設定のデータ型によって変わる!
// PDO::PARAM_STR がわからない時は　「PDO::PARAM_STR　そのほかの型」などでググると出てくる！　文字列 -> STR  整数 -> INT (日付は文字列でOK！)
// 危ないコマンドなどが入力されていないかをチェックするために bindValue (元々用意されている関数)を使う！　危ない内容だったら勝手にクリーニングして sqlの方に投げてくれる！

// $stmt->bindValue(':id',               $id,             PDO::PARAM_INT);   //idは整数なので　INT　もしかしたらいらないかも？
$stmt->bindValue(':sleep_start_time', $sleep_start_time, PDO::PARAM_STR);
$stmt->bindValue(':sleep_end_time',   $sleep_end_time,   PDO::PARAM_STR);
$stmt->bindValue(':feel',             $feel,             PDO::PARAM_INT);   //５段階評価は　INT でOK？
$stmt->bindValue(':comment',          $comment,          PDO::PARAM_STR);
// $stmt->bindValue(':created_at',       $created_at,       PDO::PARAM_STR);   // もしかしたらいらないかも
// $stmt->bindValue(':updated_at',       $updated_at,       PDO::PARAM_STR);   // もしかしたらいらないかも

// ーーーーーーーーーーーーSQL実行ーーーーーーーーーーーーーー
//（実行に失敗すると `sql error ...` が出力される）
try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    // sql 作成以降で何か間違ってたら、↓の sql error　が表示される！
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }

// ーーーーーーーーーーーーSQL実行の処理ーーーーーーーーーーーー
// work_input.php のファイルにsqlで実行した処理をリダイレクトする！
header('Location: work_input.php');
exit();



?>