<?php
/**
 * 概要   : 処理完了表示機能
 *          処理完了画面を表示する。
 * 作成者 : saito
 * 作成日 : 2013/10/10
 * 最終更新日：yyyy/mm/dd
 */

session_start();
header("Content-Type: text/html;charset=utf-8");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="ja">
<head>
<link rel="stylesheet" href="master.css" type="text/css">
<title>処理完了</title>
</head>
<body>
<?php
include('header.php');
?>
<center>
<h1>
処理完了
</h1>
<hr>
処理が完了しました
<hr>
<div align="right"><a href="MenuController.php">[メニューに戻る]</a></div>
</center>
</body>
</html>
