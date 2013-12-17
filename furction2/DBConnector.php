<?php
/**
 * 概要   : DB接続機能
 *          DBへの接続、切断機能を提供する。
 * 作成者 : original
 * 作成日 : 2013/10/10
 * 最終更新日 : yyyy/mm/dd
 */
class DBConnector {
	private static $db;

	/**
	 * DB接続処理
	 *
	 * @throws PDOException
	 */
	public static function getDB() {
		if (is_null ( self::$db )) {
			$userName = 'root';
			$password = 'mysql';
			$host = 'localhost';
			$dbName = 'furction';

			try {
				$dsn = 'mysql:host=' . $host . ';dbname=' . $dbName . ';charset=utf8';
				self::$db = new PDO ( $dsn, $userName, $password, array( PDO::ATTR_PERSISTENT => true ) );
			} catch ( PDOException $e ) {
				throw new PDOException($e);
			}
		}
		return self::$db;
	}

	/**
	 * DB切断処理
	 *
	 */
	public static function disconnectDB() {
		if (! is_null ( self::$db ))
			self::$db = null;
	}
}
?>