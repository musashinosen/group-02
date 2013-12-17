<?php
/**
 * 概要   : 商品検索コントローラー
 *          商品検索と一覧表示をコントロールする。
 * 作成者 : saito
 * 作成日 : 2013/10/10
 * 最終更新日：yyyy/mm/dd
 */
session_start();

// 本スクリプトに取り込むクラス
require_once 'View.php';            // 画面表示クラス
require_once 'ExhibitModel.php';    // 出品モデルクラス
require_once 'MyValidator.php';     // 入力チェッククラス

// 変数定義
$next_page  = 'MenuController.php'; // 次画面クラスの定義
$error_page = "error.php";          // エラー画面
$err = "";                          // エラーメッセージエリア
$arr = array();                     // 検索結果エリア

//ログインチェック
if (!array_key_exists('user', $_SESSION)) {
	header('Location: loginController.php');
	exit;
}

// 検索ボタン押下チェック
if (isset($_POST['search'])) {

	// 検索ボタン内容クリア
	unset($_POST['search']);

	// 検索条件入力チェック
	if (!inputCheck($_POST['kind'])) {
		// 画面表示用エラーメッセージ設定
		$err = $_SESSION["errmsg"];
		$_SESSION["errmsg"] = "";
	}else{
		// 出品商品検索
		if(!searchExhibit($_POST['kind'])){
			 // エラーの場合エラー画面表示
			header('Location: ' . $error_page);
			exit;
		}
	}
}

// ログイン画面の表示
$view = new View ($arr, $err);
$view->render ( "search_list.php" );
exit;

/**
 * 入力データチェック
 *
 * @param unknown_type $kind
 * @return boolean
 */
function inputCheck($kind){

	// 入力チェッククラスインスタンス生成
	$v = new MyValidator();

	// 空文字チェック
	$v->requiredCheck($kind, "検索条件");
	if ($v->is_errors()) {
		break;
	}

	// NULL code チェック
	$v->nullCheck($kind, "検索条件");
	if ($v->is_errors()) {
		break;
	}

	return true;
}

/**
 * 出品商品検索処理
 *
 * @param unknown_type $kind
 * @return boolean
 */
function searchExhibit($kind) {

	// グローバル変数宣言
	global $arr;

	try{
		// 商品検索
		$db = DBConnector::getDB();
		$model = new ExhibitModel($db);

		if($kind == "ALL"){ // 全件検索
			$arr = $model->select3();
		} else {			// 種別検索
			$arr = $model->select4($kind);
		}

		// 検索結果リターン
		return true;

	// エラー処理
	} catch ( Exception $e ) {
		// エラー画面に表示するメッセージ設定
		$_SESSION["errmsg"] = "システムエラーが発生しました。管理者に連絡してください。";

		// 検索結果リターン
		return false;
	}
}
?>
