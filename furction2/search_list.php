<?php
/**
 * 概要   : 商品検索リスト
 *          商品一覧を表示する。
 * 作成者 : saito
 * 作成日 : 2013/10/10
 * 最終更新日：yyyy/mm/dd
 */

// 変数宣言
$arr = array ();

// select ボックスの設定
$arr[0] = "<option value=\"ALL\"" . getPost("kind", "ALL") . ">全て";
$arr[1] = "<option value=\"椅子\"" . getPost("kind", "椅子") . ">椅子";
$arr[2] = "<option value=\"テーブル\"" . getPost("kind", "テーブル") . ">テーブル";
$arr[3] = "<option value=\"本棚\"" . getPost("kind", "本棚") . ">本棚";
$arr[4] = "<option value=\"事務机\"" . getPost("kind", "事務机") . ">事務机";
$arr[5] = "<option value=\"ソファ\"" . getPost("kind", "ソファ") . ">ソファ";
$arr[6] = "<option value=\"ベッド\"" . getPost("kind", "ベッド") . ">ベッド";
$arr[7] = "<option value=\"チェスト\"" . getPost("kind", "チェスト") . ">チェスト";

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
検索画面
</h1>
<hr>
<form name="myFORM" action="SearchController.php" method="post">
<table>
<tr align="left"><td>種別</td>
<td>
<select name="kind">
<?php
// selectボックスを表示
for($i = 0; $i < count($arr); $i++){
	print $arr[$i];
}
?>
</select>
</td></tr>
</table>
<p>
<input type="submit" value="検索する" name="search">
<input type="reset" value="入力クリア" onClick="return resetClick('search')"><p>
<?php
	// 検索結果を表示
	$cnt = 0;
	foreach ($this->data as $value) {
		if($cnt == 0){
			print '<table bordercolor="#008000" border="1">';
			print '<tr><td>ID</td><td>種別</td><td>商品名</td><td>開始金額</td><td>現在金額</td>';
			print '<td>終了日時</td></tr>';
		}
		print '<tr>';
		print '<td align="left"><a href="javascript:void(0);" onClick="send(\''. $value['id'] . '\')">' . $value['id'] . '</a></td>';
		print '<td align="left">' . $value['kind'] . '</td>';
		print '<td align="left">' . $value['item'] . '</td>';
		print '<td align="right">' . $value['start_price'] . '</td>';
		print '<td align="right">' . $value['current_price'] . '</td>';
		print '<td align="right">' . $value['end_date'] . '</td>';
		print '</tr>';
		$cnt = $cnt + 1;
	}
	if($cnt > 0){
		print '</table>';
	}else{
		// 検索条件が設定されている場合（初期表示では表示しない）
		if (isset($_POST['kind'])) {
			print '<table bordercolor="#008000" border="1">';
			print '<tr><td><font color="#ff0000"> 検索結果なし </font></td></tr>';
			print '</table>';
		}
	}
?>

<hr>
<div align="right">
<a href="menuController.php">[メニュー]</a>
<a href="LogoutController.php">[ログアウト]</a>
</form>
</div>
</center>
<script language="JavaScript">
<!--
function send(id) {

    var submitType = document.createElement("input");
    submitType.setAttribute("name", "id");
    submitType.setAttribute("id", "id");
    submitType.setAttribute("type", "hidden");
    submitType.setAttribute("value", id); // 値
    document.myFORM.appendChild(submitType);
	document.myFORM.action = 'BidController.php';
	document.myFORM.method = 'post';
	document.myFORM.submit();
	return true;
}
// --></script>
