<?php
/**
 * 概要         : 退会処理画面
 * 作成者       : fumi, kagawa
 * 作成日       : 2013/10/09
 * 最終更新日   : 2013/10/11
 *
 */
?>
<center>
<h1>
退会画面
</h1>
<hr>
<form action="<?php print $_SERVER['PHP_SELF']?>" onSubmit="return checkSubmit('resign')" method="post">
<table>
<tr align="left"><td>ユーザ名</td>
<td><?php print $_SESSION['user'] ?></td></tr>
<tr align="left"><td>会員本名</td>
<td><?php print $_SESSION['fullname'] ?></td></tr>
</table>
<p>
<input type="submit" value="退会する" name="resign"><p>
<hr>
<div align="right">
<a href="MenuController.php">[メニュー]</a>
<a href="LogoutController.php">[ログアウト]</a>
</div>
</form>
</center>
<script type="text/javascript"><!--
