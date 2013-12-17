<?php
/**
 * 概要   : 商品入札コントローラ
 * 作成者 : fumi, kagawa
 * 作成日 : 2013/10/10
 * 最終更新日 : 2013/10/11
 */
session_start ();

require_once 'View.php';
require_once 'BidModel.php';
require_once 'ExhibitModel.php';
require_once 'MyValidator.php';

// 変数定義
$next_page = 'regist_success.php';
$error_page = 'error.php';
$err = "";

// ログイン済みチェック
if ( !array_key_exists ( 'user', $_SESSION ) ) {
	header( 'Location: LoginController.php' );
	exit();
}

// 入札するボタン押下判定
if ( isset( $_POST ['bid'] ) ) {
	
	// リクエスト'regist'の設定値クリア
	unset( $_POST ['bid'] );
	
	// 入力データチェック
	if ( !inputCheck( $_POST ['id'], $_POST ['price'] )) {
		$err = $_SESSION ['errmsg'];
	} else {
		
		// 入札ID 入札金額 入札者の妥当性チェック
		if ( !bidCheck ( $_POST ['id'], $_POST ['price'] ) ) {
			$err = $_SESSION['errmsg'];
		} else {
			// 登録処理
			if (bidItem ( $_POST ['id'], $_POST ['price'] )) {
				//登録成功ページ表示
				header( 'Location: ' . $next_page );
				exit();
			} else {
				//エラーページ表示
				header( 'Location: ' . $error_page );
				exit();
			}
		}
	}
}

// 出品登録画面表示
$view = new View ( null, $err );
$view -> render( 'bid_form.php' );
exit();

/**
 * 入力チェック処理
 * @param unknown $id
 * @param unknown $price
 * @return boolean
 */
function inputCheck($id, $price) {
	$v = new MyValidator ();
	
	// 商品id 必須チェック
	$v->requiredCheck ( $id, '商品ID' );
	if ($v->is_errors ()) {
		$_SESSION ['errmsg'] = $v->_errors [0];
		return false;
	}
	// 商品ID 数値チェック
	$v->intTypeCheck ( $id, '商品ID' );
	if ($v->is_errors ()) {
		$_SESSION ['errmsg'] = $v->_errors [0];
		return false;
	}
	// 入札金額 空文字チェック
	$v->requiredCheck ( $price, '入札金額' );
	if ($v->is_errors ()) {
		$_SESSION ['errmsg'] = $v->_errors [0];
		return false;
	}
	// 入札金額 数値チェック
	$v->intTypeCheck ( $price, '入札金額' );
	if ($v->is_errors ()) {
		$_SESSION ['errmsg'] = $v->_errors [0];
		return false;
	}
	// 数値上限・下限チェック（1-999999999）
	$v->rangeCheck ( $price, '入札金額', 999999999, 1 );
	if ($v->is_errors ()) {
		$_SESSION ['errmsg'] = $v->_errors [0];
		return false;
	}
	return true;
}

/**
 * 入札ID　入札金額　入札者妥当性チェック
 * @param unknown $id
 * @param unknown $price
 * @return boolean
 */
function bidCheck($id, $price) {
	try {
		$db = DBConnector::getDB ();
		$model = new ExhibitModel ( $db );
		
		// 出品テーブルに終了日前の入札IDが存在するかチェック
		$arr = array ();
		$arr = $model->select( $id );
		if (! $arr) {
			$_SESSION['errmsg'] = "該当するidが見つかりません";
			return false;
		}
		// 入札者のチェック（出品社の入札を禁じる）
		foreach ( $arr as $value ) {
			$exhibit_user = $value['user'];
		}
		if ($_SESSION['user'] == $exhibit_user) {
			$_SESSION['errmsg'] = "出品者は入札できません";
			return false;
		}
		
		// 入札金額が現在価格より大きいかチェック
		$current_price = $model->selectPrice ( $id );
		if ($price <= $current_price) {
			$_SESSION ['errmsg'] = "入札額は現在の最高額より高くなければなりません";
			return false;
		}
		
		return true;
		
	} catch( PDOException $e ) {
		$_SESSION ['errmsg'] = "システムエラーが発生しました。管理者に連絡してください。";
		header ( 'Location: error.php' );
		exit();
	}
}

/**
 * 商品入札処理
 * @param unknown $id
 * @param unknown $price
 * @return boolean
 */
function bidItem($id, $price) {
	// 登録結果
	$result = false;
	
	// データ登録項目
	$bidder = $_SESSION ['user'];
	$price = $_POST ['price'];
	$id = $_POST ['id'];
	$dob = date ( 'Y-m-d H:i:s', time () );
	
	try {
		$db = DBConnector::getDB ();
		$model = new BidModel ( $db );
		$model2 = new ExhibitModel ( $db );
		$db->beginTransaction ();
		// 入札件数取得
		$count_bid = count( $model->select( $id ) );
		
		if ($count_bid != 0) {
			// 入札記録更新
			$result = $model -> update( $id, $bidder, $price );
		} else {
			// 新規入札
			$result = $model -> insert( $id, $bidder, $price );
		}
		
		// 出品テーブル更新
		$model2 -> update( $id, $price );
		
		$db -> commit();
		$result = true;
		return $result; 
		
	} catch( PDOException $e ) {
		$_SESSION['errmsg'] = "システムエラーが発生しました。管理者に連絡してください。";
		return false;
	}
}
