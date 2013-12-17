<?php
/**
 * 概要   : 会員退会コントローラ
 * 作成者 : fumi, kagawa
 * 作成日 : 2013/10/09
 * 最終更新日 : 2013/10/11
 */
//セッションの開始
session_start();

//取り込むクラス
require_once 'View.php';
require_once 'UserModel.php';

//変数定義
$next_page = 'resign_success.php';
$error_page = 'error.php';
$err = "";

//ログインチェック
if (!array_key_exists('user', $_SESSION)) {
	header('Location: loginController.php');
	exit;
}

//退会ボタン押下判定
if (isset($_POST['resign'])){

	unset($_POST['resign']);

	//退会処理
	if (resignMember($_SESSION['user'])) {
		
		//退会完了画面に遷移
		header('Location: ' . $next_page);

		//セッション削除
		$_SESSION = array();
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(),'', time()-3600, '/');
		}
		session_destroy();

		exit();
	}else{
		//エラー画面に遷移
		$_SESSION['errmsg'] = "システムエラーが発生しました。管理者に連絡してください。";
		header('Location: ' . $error_page);
		exit;
	}
}

//　退会画面表示
$view = new View(null,$err);
$view -> render('resign_form.php');
exit;

//退会処理
function resignMember($user) {

	//処理結果
	$result = false;

	try {
		//ユーザー検索
		$db = DBConnector::getDB();
		$model = new UserModel($db);
		$result = $model->delete($user);
		return $result;

	} catch (PDOException $e) {
		$_SESSION['errmsg'] = "システムエラーが発生しました。管理者に連絡してください。";
		header('Location: ' . $error_page);
		//exit;
	}

}
?>

