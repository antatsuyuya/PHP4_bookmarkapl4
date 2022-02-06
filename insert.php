<?php
//1. POSTデータ取得
$name = $_POST['name'];
$urls = $_POST['urls'];
$comment = $_POST['comment'];

//2. DB接続します
//*** function化する！  *****************

require_once("funcs.php");
$pdo = db_comn();

// try {
//     $db_name = 'gs_db3';    //データベース名
//     $db_id   = 'root';      //アカウント名
//     $db_pw   = 'root';      //パスワード：XAMPPはパスワード無しに修正してください。
//     $db_host = 'localhost'; //DBホスト
//     $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
// } catch (PDOException $e) {
//     exit('DB Connection Error:' . $e->getMessage());
// }

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, name, urls, comment, date)
                        VALUES(NULL, :name, :urls, :comment, sysdate())");

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':urls', $urls, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    sql_error($stmt);
} else {
    //*** function化する！*****************
    redirect("index.php");
}