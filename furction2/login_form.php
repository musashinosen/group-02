<?php
/**
 * 概要         : login 画面(LoginController.php)のフォーマット
 * 作成者       : saitoh
 * 作成日       : 2013/10/08
 * 最終更新日   : 2013/10/11
 */

// 変数宣言
$user = "";
$pass = "";

// 入力内容再現判定
$user = getPost("user");
$pass = getPost("pass");

/**
 * リクエストの内容取得処理
 *
 * @param unknown_type $key
 * @return Ambigous <string, unknown>
 */
function getPost($key) {

	// リクエストの内容を判定し、値を返却する
	if (isset($_POST[$key])) {
		return $_POST[$key];
	}else{
		return "";
	}
}
?>
<center>
<h1>
ログイン
</h1>
<hr>
<form name="myFORM" action="LoginController.php" method="post">
<table>
<tr>
<td><b>ログイン名<b></td>
<td><input type="text" size="20" maxlength="16" name="user" id="user" value="<?php print $user; ?>"></td>
</tr>
<tr>
<td><b>パスワード<b></td>
<td><input type="password" size="20" maxlength="16" name="pass" id="pass" value="<?php print $pass; ?>"></td>
</table>
<p>
<input type="submit" value="ログイン" name="login">
<input type="reset" value="入力クリア" onClick="return resetClick('login')"></p>
</form>
<font color="#ff0000"><b><?php print $this->msg ?></b></font><br>
<hr>
</center>
