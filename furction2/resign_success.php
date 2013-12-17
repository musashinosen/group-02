<?php
/**
 * 概要         : 退会完了画面
 * 作成者       : fumi, kagawa
 * 作成日       : 2013/10/09
 * 最終更新日   : 2013/10/11
 *
 */
session_start();
header("Content-Type: text/html;charset=utf-8");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="ja">
<head>
<link rel="stylesheet" href="master.css" type="text/css">
<title>退会処理完了</title>
</head>
<body>
<?php
include('header.php');
?>
<center>
<h1>
退会処理完了
</h1>
<hr>
今までのご利用ありがとうございました
<hr>
<div align="right"><a href="LoginController.php">[ログイン画面に戻る]</a></div>
</center>
</body>
</html>
