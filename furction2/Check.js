/**
 * 概要   : 入力チェックjavascript
 * 作成者 : saito
 * 作成日 : 2013/10/10
 * 最終更新日：yyyy/mm/dd
 */

// 二重送信防止フラグ
var sendFlg = false;

/**
 * 処理振り分け
 *
 * @param screenID
 * @returns boolean
 */
function checkSubmit(screenID) {

	// 二重送信防止チェック
	if(sendFlg){
		alert("二重送信できません！\n1度目の押下だけ有効です。");
		return false;
	}else{
		sendFlg = true;
	}

	var status = true;
	var res = false;
	var msg = "";

	// 必須入力チェック
	if(screenID != null && screenID != ""){

		// 画面振り分け判定
		if(screenID == "resign"){	// 退会画面
			if(msg != ""){
				status = false;
			}
			if(status){
			    // 確認ダイアログを表示
				status = confirm("退会処理を実行します。\n本当に退会してよろしいですか？");
			}
		}
	}
	return status;
}
