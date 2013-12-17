/**
 * 概要  :共通チェックjavascript
 * 作成者:千葉貴裕
 * 作成日:2013/10/10
 * 最終更新日：yyyy/mm/dd
 */

/**
 * 先頭および末尾の、全角空白、半角空白、タブ、を削除
 *
 * @param str
 * @returns
 */
function trimStr(str) {
	return str.replace(/^[ 　\t\r\n]+|[ 　\t\r\n]+$/g, "");
}

/**
 * 必須入力チェック
 *
 * @param arrValue
 * @param arrName
 * @returns
 */
function checkRequired(value, name){

	// 変数宣言
	errors = "";

	// 必須入力チェック
	if(value == null || value == ""){
		errors = name + "は必須入力です。";
		return errors;
	}
    return errors;
}

/**
 * 長さチェック
 *
 * @param arrValue
 * @param arrName
 * @param arrLen
 * @returns
 */
function checkByte(value, name, len){

	// 変数宣言
	errors = "";

	// 変数宣言
	var count = 0;
	var aStr = "";

	// 文字列の設定判定
	if(value != null && value != ""){

		// 文字列のバイト数取得
		for(var k=0;k<value.length;k++){

			// １文字取り出し
			aStr = value.charAt(k);

			// 16 進エンコーディング
			aStr = escape(aStr);

			// 全角・半角判定
			if( aStr.length  < 4 ){
				count = count + 1; // 半角のバイト数
			}else{
				count = count + 2; // 全角のバイト数
			}
		}
	}
	// 文字列のバイト数判定
	if(count > len){
		errors = name + "は" + len + "文字以内で入力してください。";
		return errors;
	}
	return errors;
}

/**
 * 英数字チェック
 *
 * @param arrValue
 * @param arrName
 * @returns
 */
function checkRegex(value, name) {

	// 変数宣言
	errors = "";

	// 文字列の設定判定
	if(value != null && value != ""){

		// 半角英数字チェック
		if(value.match(/[^0-9a-zA-Z]/)) {
			errors = name + "は半角英数字のみで入力してください。";
			return errors;
		}
	}
	return errors;
}

/**
 * 数字チェック
 *
 * @param arrValue
 * @param arrName
 * @returns
 */
function checkRegex2(value, name) {

	// 変数宣言
	errors = "";

	// 文字列の設定判定
	if(value != null && value != ""){

		// 半角英数字チェック
		if(value.match(/[^0-9]/)) {
			errors = name + "は半角数字のみで入力してください。";
			return errors;
		}
	}
	return errors;
}

/**
 * 禁則文字チェック
 *
 * @param arrValue
 * @param arrName
 * @returns
 */
function checkCtlCode(value, name) {

	// 変数宣言
	errors = "";

	// 文字列の設定判定
	if(value != null && value != ""){

		// 半角英数字チェック
		if(value.match(/[\x00-\x1f\x22\x26\x27\x3b\x3c\x3e]/)) {
			errors = name + "に不正な文字が含まれています";
			return errors;
		}
	}
	return errors;
}

/**
 * 範囲チェック
 *
 * @param value
 * @param name
 * @param max
 * @param min
 * @returns
 */
function checkRange(value, name, max, min) {

	// 変数宣言
	errors = "";

	// 文字列の設定判定
	if(value != null && value != ""){

		// 範囲チェック
		if (value > max || value < min) {
			errors = name + "は" + min + "～" + max + "で指定してください。";
			return errors;
		}
	}
	return errors;
}

/**
 * NULLチェック
 *
 * @param value
 * @param name
 * @returns
 */
function checkNull(value, name) {

	// 変数宣言
	errors = "";

	// 文字列の設定判定
	if(value != null && value != ""){

		if(value.match(/\\0/)) {
			errors = name + "は不正な文字を含んでいます。";
			return errors;
		}
	}
	return errors;
}


/**
 * 末日チェック
 * （各月の末日までの日付かどうかチェック）
 *
 * @param month
 * @param day
 * @returns {Boolean}
 */
function checkLastDay(month, day){

	// 末日
	lastDay = new Array(31,28,31,30,31,30,31,31,30,31,30,31,29);

	// 各月の日付妥当性チェック
	if (lastDay[month-1] >= day){
		return true;
	}else{
		return false;
	}
}

/**
 * うるう年チェック
 *
 * @param year
 * @returns {Boolean}
 */
function checkYear(year){

	// うるう年判定
	if ((year % 4) == 0 && ((year % 100) != 0 || (year % 400))){
		return true;
	}
	return false;
}
