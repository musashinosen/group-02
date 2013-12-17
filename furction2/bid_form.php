<?php
/**
 * 概要         : 入札処理画面
 * 作成者       : fumi, kagawa
 * 作成日       : 2013/10/09
 * 最終更新日   : 2013/10/11
 *
 */
?>
<center>
<h1>
入札画面
</h1>
<hr>
<form name="myFORM" action="<?php print $_SERVER['PHP_SELF']?>" onSubmit="return checkSubmit('')" method="post">
<table>
<tr align="left"><td>商品ID</td>
<td><input type="text" size="12"  maxlength="6" name="id" id="id" value="<?php if (isset($_POST['id']))print $_POST['id']; ?>"></td></tr>
<tr align="left"><td>入札金額</td>
<td><input type="text" size="12" maxlength="9" name="price" id="price" value="<?php if (isset($_POST['price']))print $_POST['price']; ?>">円</td></tr>
</table>
<p>
<input type="submit" value="入札する" name="bid">
<input type="reset" value="入力クリア" onClick="return resetClick('bid')"><p>
<font color="#ff0000"><b><?php print $this->msg ?></b></font><br>
<hr>
<div align="right">
<a href="MenuController.php">[メニュー]</a>
<a href="LogoutController.php">[ログアウト]</a>
</div>
</center>