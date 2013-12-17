<?php
/**
 * 概要         : 会員登録処理を行う。
 * 作成者       : hirooka
 * 作成日       : 2013/10/09
 * 最終更新日   : 2013/10/11
 */
session_start();

// 本スクリプトに取り込むクラス
require_once 'View.php';	  // 画面表示クラス
require_once 'UserModel.php'; // ユーザーモデルクラス
require_once 'MyValidator.php'; // 入力チェッククラス

// 変数定義
$success_page = "regist_success.php"; // 登録成功画面
$error_page = "error.php"; // エラー画面
$err = ""; // エラーメッセージエリア

// ログイン済チェック
if (!array_key_exists('user', $_SESSION)) {
	header('Location: loginController.php');
	exit;
}

// 登録ボタン押下チェック
if (isset($_POST['regist'])) {

	// 登録ボタン内容クリア
	unset($_POST['regist']);

	// 入力データチェック
	if (!inputCheck($_POST['user'], $_POST['pass'], $_POST['fullname'])) {
		// 画面表示用エラーメッセージ設定
		$err = $_SESSION["errmsg"];
		$_SESSION["errmsg"] = "";
	} else {
		// データ登録チェック
		if (addMember($_POST['user'], $_POST['fullname'], $_POST['pass'])) {
			header('Location: ' . $success_page);
			exit;
		} else {
            // ここに来るケースは、システムエラーとする。
		    $_SESSION["errmsg"] = "システムエラーが発生しました。管理者に連絡してください。";
			header('Location: ' . $error_page);
			exit;
		}
	}
}

// ログイン画面の表示
$view = new View(null, $err);
$view->render ( "member_form.php" );
exit;

/**
 * 入力データチェック
 *
 * @param unknown $user
 * @param unknown $pass
 * @return boolean
 */
function inputCheck($user, $pass, $fullname){
    global $error_page;

	// 入力チェッククラスインスタンス生成
	$v = new MyValidator();

	$tmp = [[$user,	    'ログイン名',   16],
			[$fullname, '会員氏名',     16],
			[$pass,	    'パスワード',   16]   ];
	foreach ($tmp as list($var, $name, $lenmax)) {
		if ($name == '会員氏名') {  // 会員氏名については
			if (trim($var) == '') { // 空欄ならば、
				continue;	        // チェックしない
			}
		} else {
			// 空文字チェック
			$v->requiredCheck   ($var, $name);          if ($v->is_errors()) { break; }
		}
		// NULL code チェック
		$v->nullCheck           ($var, $name);          if ($v->is_errors()) { break; }
		// Alpha-Numeric チェック
		$v->alnumCheck          ($var, $name);          if ($v->is_errors()) { break; }
		// Length max チェック
		$v->lengthCheck         ($var, $name, $lenmax); if ($v->is_errors()) { break; }
	}
	if (!$v->is_errors()) {
		// ここまでエラーなしならば、ログイン名が重複していないことをチェックする。
		try {
			$db = DBConnector::getDB ();
		    $v->duplicateCheck($user, '会員氏名', 'select * from user_regist where user = :value', $db);
		} catch (Exception $e) {
		    $_SESSION["errmsg"] = "システムエラーが発生しました。管理者に連絡してください。";
	        header('Location: ' . $error_page);
            exit;
		}
	}
	if ($v->is_errors()) {
		$_SESSION['errmsg'] = $v->_errors[0];
		return false;
	}
	return true;
}

/**
 * 会員情報登録処理
 *
 * @param unknown $user
 * @param unknown $fullname
 * @param unknown $pass
 * @return boolean
 */
function addMember($user, $fullname, $pass) {
    global $error_page;

	// 登録結果
	$result = false;

	try{
		// 会員登録
		$db = DBConnector::getDB ();
		$db->beginTransaction ();
		$model = new UserModel($db);
		$result = $model->insert($user, $pass, $fullname, 'n');
		$db->commit ();

		// 検索結果リターン
		return $result;

	// エラー処理
	} catch ( Exception $e ) {
		// エラー画面に表示するメッセージ設定
		$_SESSION["errmsg"] = "システムエラーが発生しました。管理者に連絡してください。";
	    header('Location: ' . $error_page);
        exit;
	}
}
?>
