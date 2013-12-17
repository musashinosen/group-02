<?php
/**
 * 概要   : メニューリスト
 *          メニュー一覧を表示する。
 * 作成者 : saito
 * 作成日 : 2013/10/10
 * 最終更新日：yyyy/mm/dd
 */
?>
<center>
<h1>
メニュー画面
</h1>
<!-- 【ようこそ<?php // print $_SESSION['fullname'] ?>さん】 -->
<hr>
<table>
<?php
if ($_SESSION['priv'] == 'y' || $_SESSION['priv'] == 'Y') {
?>
<tr align="left"><td><a href="MemberAddController.php">会員登録</a></td>
<td> - 新規会員を登録します</td></tr>
<?php
}
?>
<tr align="left"><td><a href="ExhibitController.php">商品の出品</a></td>
<td> - オークションに商品を出品します</td></tr>
<tr align="left"><td><a href="BidController.php">商品の入札</a></td>
<td> - オークションの商品に入札します</td></tr>
<tr align="left"><td><a href="ExhibitListController.php">出品商品の一覧</a></td>
<td> - 出品している商品の一覧を表示します</td></tr>
<tr align="left"><td><a href="BidListController.php">入札商品の一覧</a></td>
<td> - 入札している商品の一覧を表示します</td></tr>
<tr align="left"><td><a href="SearchController.php">商品の検索</a></td>
<td> - 出品されている商品の一覧を表示します</td></tr>

<?php
if ($_SESSION['priv'] != 'y' && $_SESSION['priv'] != 'Y') {
?>
<tr align="left"><td><a href="ResignController.php">会員退会</a></td>
<td> - 本システムの会員を退会します</td></tr>
<?php
}
?>

</table>
<div align="right">
<a href="LogoutController.php">[ログアウト]</a>
</div>
</center>
