/**
 * 概要   : リセットjavascript
 *          画面の入力内容をクリアする。
 * 作成者 : saito
 * 作成日 : 2013/10/11
 * 最終更新日：yyyy/mm/dd
 */

/**
 * 処理振り分け
 *
 * @param screenID
 * @returns boolean
 */
function resetClick(screenID) {

	// 必須入力チェック
	if(screenID != null && screenID != ""){

		// 画面振り分け判定
		if(screenID == "login"){		// ログイン画面

			this.document.getElementById("user").value = "";
			this.document.getElementById("pass").value = "";

		}else if(screenID == "member"){	// 会員登録画面

			this.document.getElementById("user").value = "";
			this.document.getElementById("fullname").value = "";
			this.document.getElementById("pass").value = "";

		}else if(screenID == "exhibit"){	// 出品画面

			this.document.myFORM.kind.selectedIndex = 0;
			this.document.getElementById("item").value = "";
			this.document.getElementById("start_price").value = "";
			this.document.myFORM.year.selectedIndex = 0;
			this.document.myFORM.month.selectedIndex = 0;
			this.document.myFORM.day.selectedIndex = 0;
			this.document.myFORM.hour.selectedIndex = 0;
			this.document.myFORM.min.selectedIndex = 0;
		}else if(screenID == "bid"){	// 入札画面

			this.document.getElementById("id").value = "";
			this.document.getElementById("price").value = "";

		}else if(screenID == "search"){	// 商品の検索画面

			this.document.myFORM.kind.selectedIndex = 0;

		}
	}
	return false;
}
