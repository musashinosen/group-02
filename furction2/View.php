<?php
/**
 * 概要   : 画面表示共通ビュー
 * 作成者 : saito
 * 作成日 : 2013/10/10
 * 最終更新日：yyyy/mm/dd
 */

class View {
	public $data; // ユーザーに見せたいデータを格納する変数
	public $msg; // ユーザーに見せたいメッセージを格納する変数

	/**
	 * コンストラクター
	 *
	 * @param unknown_type $data
	 * @param unknown_type $msg
	 */
	public function __construct($data = NULL, $msg = NULL) {
		$this->data = $data;
		$this->msg = $msg;
	}

	/**
	 * データ設定
	 *
	 * @param unknown_type $data
	 */
	public function setData($data) {
		$this->data = $data;
	}

	/**
	 * 画面表示処理
	 *
	 * @param unknown_type $page
	 */
	public function render($page) {
		print '<html lang="ja">';
		print '<head>';
		print '<meta http-equiv="content-type" content="text/html; charset=utf-8">';
		print '<link rel="stylesheet" href="master.css" type="text/css">';
		print '<script type="text/javascript" src="Check.js"></script>';
		print '<script type="text/javascript" src="Reset.js"></script>';
		print '<title>AuctionSystem Prototype</title>';
		print '</head>';
		print '<body>';

		include ('header.php');

		// ボディ部分は要求されたファイル名を読み込むことで表示する
		require_once $page;

		print '</body>';
		print '</html>';
	}
}

