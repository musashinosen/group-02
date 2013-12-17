<?php
/**
 * 概要   : ヘッダー表示機能
 *          ヘッダーを表示する。
 * 作成者 : saito
 * 作成日 : 2013/10/10
 * 最終更新日：yyyy/mm/dd
 */
?>

<SCRIPT language=JavaScript type=text/javascript>
	function displayDate(){
	  var this_month = new Array(12);
	  this_month[0]  = "January";
	  this_month[1]  = "February";
	  this_month[2]  = "March";
	  this_month[3]  = "April";
	  this_month[4]  = "May";
	  this_month[5]  = "June";
	  this_month[6]  = "July";
	  this_month[7]  = "August";
	  this_month[8]  = "September";
	  this_month[9]  = "October";
	  this_month[10] = "November";
	  this_month[11] = "December";
	  var today = new Date();
	  var day   = today.getDate();
	  var month = today.getMonth();
	  var year  = today.getYear();
	  if (year < 1900){
		 year += 1900;
	  }
	  return(day+" "+this_month[month]+" " +year);
	}
</SCRIPT>
<center>
<table summary="layout" width="650" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" >
  <tr>
 	<td bgcolor="#FFFFFF" width="10"></td>
	<td bgcolor="#FFFFFF" align="left" border="0">
	  <FONT color="#7A7A7A">
	  <SCRIPT language=JavaScript type=text/javascript>
		document.write(displayDate());
	  </SCRIPT>
	  </FONT>
	</td>
  </tr>
</table>

<TABLE summary="layout" width="680" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
	<tr>
	  <TD align="center" bgcolor="#2E2E6A">
		<BR>
		<!-- タイトル編集 -->
	<font color = "white" size="5"><b><i>AuctionSystem Prototype</i></b></font>
		<!-- 編集終了 -->
		<BR>
		<BR>
	  </TD>
	</tr>
	<tr>
	  <TD align="right" height="20" bgcolor="#696969">
		<b>
	  <?php
		if (array_key_exists('user',$_SESSION)) {
			echo "<font color='#ffffff'>【ようこそ </font>";
			echo "<font color='#ffff00'> " . $_SESSION['fullname'] . "</font>";
			echo "<font color='#ffffff'> さん】</font>";
		}
	  ?>
		</b>
		</TD>
	</tr>
</TABLE>

<?php
// ログイン済チェック
if (array_key_exists('user', $_SESSION)) {
?>
<TABLE width="780" border="0" cellpadding="0" cellspacing="0">
	<tr>
	  <TD align="center">
		<BR>
		<!-- タイトル編集 -->
	<font color="#2E2E6A" size="3"><b>
<?php
if ($_SESSION['priv'] == 'y' || $_SESSION['priv'] == 'Y') {
?>
	<a href="MemberAddController.php">会員登録</a> |
<?php
}
?>
	<a href="ExhibitController.php">商品の出品</a> |
	<a href="BidController.php">商品の入札</a> |
	<a href="ExhibitListController.php">出品商品の一覧</a> |
	<a href="BidListController.php">入札商品の一覧</a> |
	<a href="SearchController.php">商品の検索</a>
<?php
if ($_SESSION['priv'] != 'y' && $_SESSION['priv'] != 'Y') {
?>
	 |
	<a href="ResignController.php">会員退会</a>
<?php
}
?>
	</b></font>
		<!-- 編集終了 -->
		<BR>
		<BR>
	  </TD>
	</tr>
</TABLE>
<?php
}
?>
</center>
<BR>
