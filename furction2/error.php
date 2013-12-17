<?php
/**
 * 概要   : システムエラー表示機能
 *          システムエラーを表示する。
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
<title>エラー</title>
</head>
<body>
<?php
include('header.php');
?>
<center>
<h1>
ERROR！
</h1>
<hr>
<font color="#ff0000">
<?php
print $_SESSION["errmsg"];
$_SESSION["errmsg"] = "";
?><br>
</font>
<hr>
</center>
</body>
</html>
