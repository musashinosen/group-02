<?php
/**
 * 概要   : 共通チェック機能
 * 作成者 : takeuchi, hirooka
 * 作成日 : 2013/10/10
 * 最終更新日 : 2013/10/11
 */
require_once 'DBConnector.php';

class MyValidator {
	public $_errors;

	/**
	 * コンストラクター
	 *
	 */
	public function __construct() {
		$_errors = array();
		$this->checkEncoding($_GET);
		$this->checkEncoding($_POST);
		$this->checkEncoding($_COOKIE);
		$this->checkNull($_GET);
		$this->checkNull($_POST);
		$this->checkNull($_COOKIE);
	}

	/**
	 * エンコードチェック処理
	 * 指定したエンコーディングで有効なものかどうかを調べる
	 *
	 * @param array $data
	 */
	public function checkEncoding(array $data) {
		foreach($data as $key => $value) {
			if (!mb_check_encoding($value)) {
				$this->_errors[] = "{$key}は不正な文字コードです。";
			}
		}
	}

	/**
	 * エラー設定チェック処理
	 *
	 */
	public function is_errors() {
        return ($this->_errors[0]!='');
    }

    /**
     * nullチェック処理（配列バージョン）
     *
     * @param array $data
     */
	public function checkNull(array $data) {
		foreach($data as $key => $value) {
			if (preg_match('/\0/', $value)) {
				$this->_errors[] = "{$key}は不正な文字を含んでいます。";
			}
		}
	}

	/**
	 * nullチェック処理（単一バージョン）
	 *
	 * @param unknown_type $value
	 * @param unknown_type $name
	 */
	public function nullCheck($value, $name) {
        if (preg_match('/\0/', $value)) {
	        $this->_errors[] = "{$name}は不正な文字を含んでいます。";
		}
	}

	/**
	 * 必須チェック処理
	 *
	 * @param unknown_type $value
	 * @param unknown_type $name
	 */
	public function requiredCheck($value, $name) {
		if (trim($value) === '') {
			$this->_errors[] = "{$name}は必須入力です。";
		}
	}

	/**
	 * レングスチェック処理
	 *
	 * @param unknown_type $value
	 * @param unknown_type $name
	 * @param unknown_type $len
	 */
	public function lengthCheck($value, $name, $len) {
		if (trim($value) !== '') {
			if (mb_strlen($value) > $len) {
				$this->_errors[] = "{$name}は{$len}文字以内で入力してください。";
			}
		}
	}

	/**
	 * 数値チェック処理
	 *
	 * @param unknown_type $value
	 * @param unknown_type $name
	 */
	public function intTypeCheck($value, $name) {
		if (trim($value) !== '') {
			if (!ctype_digit($value)) {
				$this->_errors[] = "{$name}は数値で指定してください。";
			}
		}
	}

	/**
	 * 範囲チェック処理
	 *
	 * @param unknown_type $value
	 * @param unknown_type $name
	 * @param unknown_type $max
	 * @param unknown_type $min
	 */
	public function rangeCheck($value, $name, $max, $min) {
		if (trim($value) !== '') {
			if ($value > $max || $value < $min) {
				$this->_errors[] = "{$name}は{$min}～{$max}で指定してください。";
			}
		}
	}

	/**
	 * 日付形式チェック処理
	 *
	 * @param unknown_type $value
	 * @param unknown_type $name
	 */
	public function dateTypeCheck($value, $name) {
		if (trim($value) !== '') {
			$res = preg_split('|([/\-])|', $value);
			if (count($res) !== 3 || !@checkdate($res[1], $res[2], $res[0])) {
				$this->_errors[] = "{$name}は日付形式で入力してください。";
			}
		}
	}

	/**
	 * 正規表現によるマッチング処理
	 *
	 * @param unknown_type $value
	 * @param unknown_type $name
	 * @param unknown_type $pattern
	 */
	public function regexCheck($value, $name, $pattern) {
		if (trim($value) !== '') {
			if (!preg_match($pattern, $value)) {
				$this->_errors[] = "{$name}は正しい形式で入力してください。";
			}
		}
	}

	/**
	 * 半角英数字チェック処理
	 *
	 * @param unknown_type $value
	 * @param unknown_type $name
	 */
	public function alnumCheck($value, $name) {
		if (trim($value) !== '') {
			$pattern = "/^[0-9A-Za-z]+$/";
			if (!preg_match($pattern, $value)) {
				$this->_errors[] = "{$name}は半角英数字のみで入力してください。";
			}
		}
	}

	/**
	 * 禁則文字チェック処理
	 * （制御コード、"""、"&"、"'"、";"、"<"、">" ）
	 * @param unknown_type $value
	 * @param unknown_type $name
	 */
	public function ctlcodeCheck($value, $name) {
		if (trim($value) !== '') {
			// $pattern = "/[\x00-\x1f\x22\x26\x27\x3b\x3c\x3e]+/";
			$pattern = "/[\x01-\x1f\x22\x26\x27\x3b\x3c\x3e]+/";
			if (preg_match($pattern, $value)) {
				$this->_errors[] = "{$name}に不正な文字が含まれています。";
			}
		}
	}

	/**
	 * 値存在チェック
	 * 配列に値があるかチェック
	 *
	 * @param unknown_type $value
	 * @param unknown_type $name
	 * @param unknown_type $opts
	 */
	public function inArrayCheck($value, $name, $opts) {
		if (trim($value) !== '') {
			if (!in_array($value, $opts)) {
				$tmp = implode(',', $opts);
				$this->_errors[] = "{$name}は{$tmp}の中から選択してください。";
			}
		}
	}

	/**
	 * 重複チェック
	 *
	 * @param unknown_type $value
	 * @param unknown_type $name
	 * @param unknown_type $sql
	 * @param unknown_type $db
	 */
	public function duplicateCheck($value, $name, $sql, $db) {
		try {
			$stt = $db->prepare($sql);
			$stt->bindValue(':value', $value);
			$stt->execute();
			if (($row = $stt->fetch()) !== FALSE) {
				$this->_errors[] = "{$name}は重複しています。";
			}
		} catch(PDOException $e) {
			$this->_errors[] = $e->getMessage();
		}
	}

	/**
	 * 存在チェック
	 *
	 * 　使用例)
	 *   $v = new MyValidator();
	 *   $v->existCheck($id, '商品ID', 'select count(id) from exhibit_regist where id = :value', $db);
	 *
	 * @param unknown_type $value
	 * @param unknown_type $name
	 * @param unknown_type $sql
	 * @param unknown_type $db
	 */
	public function existCheck($value, $name, $sql, $db) {
		$row = 0;
		try {
			$stt = $db->prepare($sql);
			$stt->bindValue(':value', $value);
			$stt->execute();

			if (($row = $stt->fetchColumn()) == 0) {
				$this->_errors[] = "指定された{$name}は存在しません。";
			}
		} catch(PDOException $e) {
			$this->_errors[] = $e->getMessage();
		}
	}

	/**
	 * エラー存在チェック
	 */
	public function __invoke() {
		if (count($this->_errors) > 0) {
			print '<ul style="color:Red">';
			foreach ($this->_errors as $err) {
				print "<li>{$err}</li>";
			}
			print '</ul>';
			die();
		}
	}

	/**
	 * 日付の妥当性チェック
	 * 入力された年月日が妥当な日付かどうかチェックを行う。
	 *
	 * @param unknown_type $year 年
	 * @param unknown_type $month 月
	 * @param unknown_type $day 日
	 * @param unknown_type $name
	 */
	public function dateCheck($year, $month, $day, $name) {

		//閏年
		if(($month == 2) && $this->checkYear($year)){
			$month = 13;
		}

		//末日チェック
		if (!$this->checkLastDay($month, $day)){
			$this->_errors[] = "{$name}は不正な日付が入力されています。";
		}
	}

	/**
	 * 末日チェック
	 * （各月の末日までの日付かどうかチェック）
	 *
	 * @param month
	 * @param day
	 * @returns {Boolean}
	 */
	public function checkLastDay($month, $day){

		// 各月の末日
		$lastDay = array(31,28,31,30,31,30,31,31,30,31,30,31,29);

		// 各月の日付妥当性チェック
		if($lastDay[$month-1] >= $day){
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
	public function checkYear($year){

		// うるう年判定
		if(($year % 4) == 0 && (($year % 100) != 0 || ($year % 400))){
			return true;
		}
		return false;
	}

	/**
	 * 未来日チェック
	 *
	 * @param unknown_type $year
	 * @param unknown_type $month
	 * @param unknown_type $day
	 * @param unknown_type $hour
	 * @param unknown_type $min
	 * @param unknown_type $name
	 */
	public function futureDateCheck($year, $month, $day, $hour , $min, $name){

		$now_i = time();
		$enddate = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min . ':00';
		$enddate_i = strtotime($enddate);

		if ($enddate_i < $now_i){
			$this->_errors[] = "{$name}は現在日時以前では指定できません";
		}
	}
}
