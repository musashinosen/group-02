<?php
//セッションの開始
session_start();

//取り込むクラス
require_once 'View.php';
require_once 'ExhibitModel.php';
require_once 'MyValidator.php';

//変数定義
$next_page = 'regist_success.php';
$error_page = 'error.php';
$err = "";

//ログイン済みチェック
if (!array_key_exists('user',$_SESSION)) {
	header('Location: LoginController.php');
	exit;
}

//　出品するボタン押下判定
if (isset($_POST['regist'])) {
	
	//リクエスト'regist'の設定値クリア
	unset($_POST['regist']);
	
	//入力データチェック
	if (!inputCheck($_POST['kind'],$_POST['item'],$_POST['start_price'],
		$_POST['year'],$_POST['month'],$_POST['day'],
		$_POST['hour'],$_POST['min'])){
		
		//エラーがある場合
		$err = $_SESSION['errmsg'];
		$_SESSION['errmsg'] = '';
		
	}else{
		//登録処理
		if(registItem($_POST['kind'],$_POST['item'],$_POST['start_price'],
				$_POST['year'],$_POST['month'],$_POST['day'],
				$_POST['hour'],$_POST['min'])){
			//登録成功
//			header('Location: ' . $next_page);
			exit;
		}else{
			//登録失敗
// 			header('Location: ' . $error_page);
// 			exit;
			$err = $_SESSION['errmsg'];
		}
	}
}

//　出品登録画面表示
$view = new View(null,$err);
$view -> render('exhibit_form.php');
exit;

/**
 * 入力チェック
 *
 * @param unknown $item
 * @param unknown $start_price
 * @param unknown $year, $month, $day, $hour, $min
 * @return boolean
 */

function inputCheck( $kind, $item, $start_price, $year, $month, $day, $hour, $min ){

	// 入力チェッククラスインスタンス生成
	$v = new MyValidator();

	// 商品名　NULL　空文字　
	$v->requiredCheck($item, '商品名');
	if ($v->_errors[0] != null && $v->_errors[0] != '') {
		$_SESSION['errmsg'] = $v->_errors[0];
		return false;
	}
	// 商品名　禁則文字　\0
	$v->nullCheck($item, '商品名');
	if ($v->_errors[0] != null && $v->_errors[0] != '') {
		$_SESSION['errmsg'] = $v->_errors[0];
		return false;
	}
	// 商品名　maxlength=64
	$v->lengthCheck($item, '商品名', 64);
	if ($v->_errors[0] != null && $v->_errors[0] != '') {
		$_SESSION['errmsg'] = $v->_errors[0];
		return false;
	}
	// 商品名　不正文字コード
	$v->nullCheck($item, '商品名');
	if ($v->_errors[0] != null && $v->_errors[0] != '') {
		$_SESSION['errmsg'] = $v->_errors[0];
		return false;
	}
	$v->ctlcodeCheck($item, '商品名');
	if ($v->_errors[0] != null && $v->_errors[0] != '') {
		$_SESSION['errmsg'] = $v->_errors[0];
		return false;
	}

	// 開始価格　NULL
	$v->requiredCheck($start_price, '開始価格');
	if ($v->_errors[0] != null && $v->_errors[0] != '') {
		$_SESSION['errmsg'] = $v->_errors[0];
		return false;
	}
	
	// 開始価格　空文字
	$v->requiredCheck($start_price, '開始価格');
	if ($v->_errors[0] != null && $v->_errors[0] != '') {
		$_SESSION['errmsg'] = $v->_errors[0];
		return false;
	}
	// 数値チェック
	$v->intTypeCheck($start_price, '開始価格');
	if ($v->_errors[0] != null && $v->_errors[0] != '') {
		$_SESSION['errmsg'] = $v->_errors[0];
		return false;
	}
	// 数値上限・下限（1-999999999）
	$v->rangeCheck($start_price, '開始価格', 999999999, 1);
	if ($v->_errors[0] != null && $v->_errors[0] != '') {
		$_SESSION['errmsg'] = $v->_errors[0];
		return false;
	}
	//終了日作成
	$v->futureDateCheck($year, $month, $day, $hour , $min, 'オークション終了日');
	if ($v->_errors[0] != null && $v->_errors[0] != '') {
		$_SESSION['errmsg'] = $v->_errors[0];
		return false;
	}
	//ありえない日付
	$v->dateCheck($year, $month, $day, 'オークション終了日');
	if ($v->_errors[0] != null && $v->_errors[0] != '') {
		$_SESSION['errmsg'] = $v->_errors[0];
		return false;
	}
	return true;
}

/**
 * 出品商品登録処理
 *
 * @param unknown $kind
 * @param unknown $item
 * @param unknown $start_price
 * @param unknown $start_price
 * @return boolean
 */
function registItem( $kind, $item, $start_price, $year, $month, $day, $hour, $min ){
		
	// 登録結果
	$result = false;
	
	// データ登録項目
	$user = $_SESSION['user'];
	$current_price = $start_price;
	$start_date = date('Y-m-d H:i:s', time());
	$end_date = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min . ':00';
	//$end_date = strtotime($enddate);
	
	var_dump($user);
	var_dump($kind);
	var_dump($start_price);
	var_dump($start_date);
	var_dump($end_date);
	
	
	try {
		//出品商品登録
		$db = DBConnector::getDB();
		$db->beginTransaction ();
		$model = new ExhibitModel($db);
		$result = $model->insert($user, $kind, $item, $start_price, $current_price, $start_date, $end_date);
		$db->commit ();
		
		// 検索結果リターン
		return $result;//成功するとtrueを返す
	
	} catch (PDOException $e) {
		// エラー画面に表示するメッセージ設定
		$_SESSION['errmsg'] = "システムエラーが発生しました。管理者に連絡してください。";
		
		// 検索結果リターン
		return $result;
	}
}
