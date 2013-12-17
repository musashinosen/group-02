<?php
/**
 * 概要         : 出品画面
 * 作成者       : fumi, kagawa
 * 作成日       : 2013/10/09
 * 最終更新日   : 2013/10/11
 *
 */
// 変数宣言
$arr0 = array ();
$arr1 = array ();
$arr2 = array ();
$arr3 = array ();
$arr4 = array ();
$arr5 = array ();

// 種別 select ボックスの設定
$arr0[0] = "<option value=\"椅子\"" . getPost("kind", "椅子") . ">椅子" . "</option>";
$arr0[1] = "<option value=\"テーブル\"" . getPost("kind", "テーブル") . ">テーブル" . "</option>";
$arr0[2] = "<option value=\"本棚\"" . getPost("kind", "本棚") . ">本棚" . "</option>";
$arr0[3] = "<option value=\"事務机\"" . getPost("kind", "事務机") . ">事務机" . "</option>";
$arr0[4] = "<option value=\"ソファ\"" . getPost("kind", "ソファ") . ">ソファ" . "</option>";
$arr0[5] = "<option value=\"ベッド\"" . getPost("kind", "ベッド") . ">ベッド" . "</option>";
$arr0[6] = "<option value=\"チェスト\"" . getPost("kind", "チェスト") . ">チェスト" . "</option>";

// 年 select ボックスの設定
$yyyy = 2013;
for($i = 0; $i < 10; $i++){
	$arr1[$i] = "<option value=\"" . $yyyy . "\"" . getPost("year", $yyyy) . ">" . $yyyy . "</option>";
	$yyyy = $yyyy + 1;
}

// 月 select ボックスの設定
$mon = 0;
for($i = 0; $i < 12; $i++){
	$mon = $mon + 1;
	$arr2[$i] = "<option value=\"" . $mon . "\"" . getPost("month", $mon) . ">" . $mon . "</option>";
}

// 日 select ボックスの設定
$day = 0;
for($i = 0; $i < 31; $i++){
	$day = $day + 1;
	$arr3[$i] = "<option value=\"" . $day . "\"" . getPost("day", $day) . ">" . $day . "</option>";
}

// 時 select ボックスの設定
$hour = 0;
for($i = 0; $i < 24; $i++){
	$arr4[$i] = "<option value=\"" . $hour . "\"" . getPost("hour", $hour) . ">" . $hour . "</option>";
	$hour = $hour + 1;
}

// 分 select ボックスの設定
$min = 0;
for($i = 0; $i < 12; $i++){
	$arr5[$i] = "<option value=\"" . $min . "\"" . getPost("min", $min) . ">" . $min . "</option>";
	$min = $min + 5;
}

/**
 * selectボックスの選択判定処理
 *
 * @param unknown_type $key
 * @param unknown_type $value
 * @return string
 */
function getPost($key, $value) {

	// リクエストの内容を判定し、値を返却する
	if (isset($_POST[$key]) && $_POST[$key] == $value) {
		return "selected";
	}else{
		return "";
	}
}
?>

<center>
<h1>
出品画面
</h1>
<hr>
<form name="myFORM" action="<?php print $_SERVER['PHP_SELF']?>" onSubmit="return checkSubmit('')" method="post">
<table>
<tr align="left"><td>種類</td>
<td>
<select name="kind">
<?php
// selectボックスを表示
for($i = 0; $i < count($arr0); $i++){
	print $arr0[$i];
}
?>
</select>
</td></tr>
<tr align="left"><td>商品名</td>
<td><input type="text" size="64" maxlength="64" name="item" id="item" value="<?php if (isset($_POST['item']))print $_POST['item']; ?>"></td></tr>
<tr align="left"><td>開始価格</td>
<td><input type="text" size="9" maxlength="9" name="start_price" id="start_price" value="<?php if (isset($_POST['start_price']))print $_POST['start_price']; ?>">円</td></tr>
<tr align="left"><td>終了日時</td>
<td>
<select name="year" id="year">
<?php
// selectボックスを表示
for($i = 0; $i < count($arr1); $i++){
	print $arr1[$i];
}
?>
</select>年
<select name="month" id="month">
<?php
// selectボックスを表示
for($i = 0; $i < count($arr2); $i++){
	print $arr2[$i];
}
?>
</select>月
<select name="day" id="day">
<?php
// selectボックスを表示
for($i = 0; $i < count($arr3); $i++){
	print $arr3[$i];
}
?>
</select>日
<select name="hour" id="hour">
<?php
// selectボックスを表示
for($i = 0; $i < count($arr4); $i++){
	print $arr4[$i];
}
?>
</select>時
<select name="min" id="min">
<?php
// selectボックスを表示
for($i = 0; $i < count($arr5); $i++){
	print $arr5[$i];
}
?>
</select>分
</td></tr>
</table>
<p>
<input type="submit" value="出品する" name="regist">
<input type="reset" value="入力クリア" onClick="return resetClick('exhibit')"><p>
<font color="#ff0000"><b><?php print $this->msg ?></b></font><br>
<hr>
<div align="right">
<a href="MenuController.php">[メニュー]</a>
<a href="LogoutController.php">[ログアウト]</a>
</div>
</form>
</center>