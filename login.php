<?php

/**
 * １．PHP
 * [ここでやりたいこと]
 * まず、クエリパラメータの確認 = GETで取得している内容を確認する
 * イメージは、select.phpで取得しているデータを一つだけ取得できるようにする。
 * →select.phpのPHP<?php ?>の中身をコピー、貼り付け
 * ※SQLとデータ取得の箇所を修正します。
 */

$_GET["id"];
//urlで贈られてくるものをidをもらう

//DBに接続
require_once("funcs.php");
$pdo = db_comn();

//２．データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM gs_user_table WHERE id = :id');
$stmt->bindValue(":id",$id,PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
$view = '';
if ($status === false) {
    sql_error($stmt);
    //ここ修正（関数化）
} else {
    //データが取得出来たら
    $view = $stmt->fetch();
}

// var_dump ($view);

?>

<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
(入力項目は「登録/更新」はほぼ同じになるから)
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>データ登録</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
            </div>
        </nav>
    </header>

    <!-- method, action, 各inputのnameを確認してください。  -->
    <form method="POST" action="login_act.php">
        <div class="jumbotron">
            <fieldset>
            <legend>ユーザー管理画面</legend>
                <label>名前：<input type="text" name="name"></label><br>
                <label>ユーザーID：<input type="text" name="lid"></label><br>
                <label>passward：<input type="text" name="lpw"></label><br>
                <!-- 追加 -->
                <input type="hidden" name="id" value=<?$view["id"] ?>></label><br>
                <!--  -->
                <input type="submit" value="ログイン">
            </fieldset>
        </div>
    </form>
</body>

</html>
