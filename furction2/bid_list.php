<?php
/**
 * 概要         : 入札一覧表示のため、BidListController.php から view class に渡されて
 *                利用される。
 * 作成者       : hirooka
 * 作成日       : 2013/10/09
 * 最終更新日   : 2013/10/11
 *
 * 参考にしたファイル：search_list.php
 */
?>
<center>
<h1>
入札一覧
</h1>
<hr>
<p>
<?php
	// 検索結果を表示
	$cnt = 0;
	foreach ($this->data as $value) {
		if($cnt == 0){
			print '<table bordercolor="#008000" border="1">';
			print '<tr><td>ID</td><td>種別</td><td>商品名</td><td>開始金額</td><td>現在金額</td>';
            print '<td>終了日時</td><td>入札日時</td></tr>';
		}
		print '<tr>';
		print '<td align="left">' .  $value['id'] .             '</td>';
		print '<td align="left">' .  $value['kind'] .           '</td>';
		print '<td align="left">' .  $value['item'] .           '</td>';
		print '<td align="right">' . $value['start_price'] .    '</td>';
		print '<td align="right">' . $value['price'] .          '</td>';
		print '<td align="right">' . $value['end_date'] .       '</td>';
		print '<td align="right">' . $value['dob'] .            '</td>';
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
</div>
</center>




