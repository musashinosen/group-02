<?php
/**
 * 概要         : login 画面を制御するクラス
 *                user と password で認証する。
 * 作成者       : saitoh, hirooka
 * 作成日       : 2013/10/08
 * 最終更新日   : 2013/10/11
 */
// セッション開始
session_start();

// 本スクリプトに取り込むクラス
require_once 'View.php';	  // 画面表示クラス
require_once 'UserModel.php'; // ユーザーモデルクラス
require_once 'MyValidator.php'; // 入力チェッククラス

// 変数定義
$next_page = 'MenuController.php'; // 次画面クラスの定義
$error_page = 'error.php'; // エラー画面
$err = ''; // エラーメッセージエリア

// セッション情報クリア
// ログイン済チェック
if (array_key_exists('user', $_SESSION)) {
	// セッション変数を全て解除する
	$_SESSION = array();
}

// ログインボタン押下判定（リクエストの項目'login'に値が設定されているかチェック）
if (isset($_POST['login'])) {

	// リクエストの項目'login'の設定値をクリア
	unset($_POST['login']);

	// 入力データチェック
	if (!inputCheck($_POST['user'], $_POST['pass'])) {
		// 画面表示用エラーメッセージ設定
		$err = $_SESSION['errmsg'];
		$_SESSION['errmsg'] = '';
	} else {
		// ログインチェック
		if (!loginCheck($_POST['user'], $_POST['pass'])) {
		    // システムエラーチェック
			if (isset($_SESSION['errmsg']) && $_SESSION['errmsg'] != '') {
				// エラー画面に遷移
				header('Location: ' . $error_page);
				exit;
			} else {
				$err = 'ユーザ名 [' . $_POST['user'] . ']の認証に失敗しました';
			}
		} else {
			// メニュー画面に遷移
			header('Location: ' . $next_page);
			exit;
		}
	}
}

// ログイン画面の表示
$view = new View(null, $err);
$view->render ( 'login_form.php' );
exit;

/**
 * 入力チェック
 *
 * @param unknown $user
 * @param unknown $pass
 * @return boolean
 */
function inputCheck($user, $pass){

	// 入力チェッククラスインスタンス生成
	$v = new MyValidator();

    $tmp=[  [$user, 'ログイン名', 16],
            [$pass, 'パスワード', 16]   ];
	foreach ($tmp as list($var, $name, $lenmax)) {
		// 空文字チェック
		$v->requiredCheck   ($var, $name);          if ($v->is_errors()) { break; }
		// NULL code チェック
		$v->nullCheck       ($var, $name);          if ($v->is_errors()) { break; }
		// Alpha-Numeric チェック
        $v->alnumCheck      ($var, $name);          if ($v->is_errors()) { break; }
		// Length max チェック
		$v->lengthCheck     ($var, $name, $lenmax); if ($v->is_errors()) { break; }
	}
	if ($v->is_errors()) {
		$_SESSION['errmsg'] = $v->_errors[0];
		return false;
	}
	return true;
}

/**
 * ログインチェック
 *
 * @param unknown $user
 * @param unknown $pass
 * @return boolean
 */
function loginCheck($user, $pass) {

	// 登録結果
	$result = false;

	try{
		// ユーザー検索
		$db = DBConnector::getDB ();
		$db->beginTransaction ();
		$model = new UserModel($db);
		$result = $model->select($user, $pass);
		$db->commit ();

		// 検索結果リターン
		return $result;

	// エラー処理
	} catch ( Exception $e ) {

		// エラー画面に表示するメッセージ設定
		$_SESSION['errmsg'] = 'システムエラーが発生しました。管理者に連絡してください。';

		// 検索結果リターン
		return false;
	}
}
?>


