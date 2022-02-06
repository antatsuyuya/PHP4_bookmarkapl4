<?php
//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更


//DBに接続
//SQL => update////
//updateできたらredirectする

//1. POSTデータ取得
$name = $_POST['name'];
$urls = $_POST['urls'];
$comment = $_POST['comment'];

//2. DB接続します
//*** function化する！  *****************

require_once("funcs.php");
$pdo = db_comn();


//３．データ登録SQL作成
$stmt = $pdo->prepare("UPDATE 
                        gs_bm_table 
                        SET name = :name,
                        urls = :urls,
                        comment = :comment,
                        indate = sysdate()
                      WHERE
                        id = :id;
                        ");

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':urls', $urls, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    sql_error($stmt);
} else {
    //*** function化する！*****************
    redirect("select.php");
}