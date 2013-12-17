<?php
/**
 * 概要         : 入札を user 一致で検索して一覧表示する。
 * 作成者       : hirooka
 * 作成日       : 2013/10/09
 * 最終更新日   : 2013/10/11
 *
 * 参考にしたファイル：SearchController.php 
 */
session_start();

// 本スクリプトに取り込むクラス
require_once 'View.php';            // 画面表示クラス
require_once 'BidModel.php';        // 入札モデルクラス

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

//
// 入札商品検索
if (!searchBid($_SESSION['user'])) {
    // エラーの場合エラー画面表示
    header('Location: ' . $error_page);
    exit;
}

// 検索結果の表示
$view = new View ($arr, $err);
$view->render ( "bid_list.php" );
exit;

/*
 * 入札検索処理
 *
 * 入力:    $user
 * 出力:
 *          global $arr:        検索結果内容
 *          関数値(true/false): 検索の成功/失敗
 *
 */
function searchBid($user) {

	// グローバル変数宣言
    global $arr;
	try{
		// 商品検索
		$db = DBConnector::getDB();
		$model = new BidModel($db);

	    $arr = $model->select_by_user($user);

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

