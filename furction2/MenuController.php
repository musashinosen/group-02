<?php
/**
 * 概要   : メニューコントローラー
 *          メニュー一覧表示をコントロールする。
 * 作成者 : saito
 * 作成日 : 2013/10/10
 * 最終更新日：yyyy/mm/dd
 */

// セッション開始
session_start();

// ログイン済チェック
if (!array_key_exists('user', $_SESSION)) {
	header('Location: loginController.php');
	exit;
}

// 本スクリプトに取り込むクラス
require_once 'View.php';      // 画面表示クラス

// ログイン画面の表示
$view = new View(null, null);
$view->render ( "menu_list.php" );
exit;
?>
