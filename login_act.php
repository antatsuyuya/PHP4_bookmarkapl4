<?php

session_start();

//1. POSTデータ取得
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

//2. DB接続します
//*** function化する！  *****************

require_once("funcs.php");
$pdo = db_comn();


//３．データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM gs_user_table WHERE lid = :lid AND lpw = :lpw');

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行

//3. SQL実行時にエラーがある場合STOP
if($status === false){
    sql_error($stmt);
}

//4. 抽出データ数を取得 あっている場合（前回の課題処理と同じ）
$val = $stmt->fetch();

//if(password_verify($lpw, $val['lpw'])){ //* PasswordがHash化の場合はこっちのIFを使う
if( $val['id'] != ''){
    $_SESSION['chk_ssid'] = session_id();
    $_SESSION['kanri_flg'] = $val['kanri_flg'];
    $_SESSION['name'] = $val['name'];
    header('Location: select.php');
    header('Location: select.php');
}else{
    //Login失敗時(Logout経由)
    header('Location: login.php');
}

exit();
