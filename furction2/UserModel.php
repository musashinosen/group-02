<?php
/**
 * 概要   : ユーザーモデル
 *          user_registテーブルへのアクセス機能を提供する。
 * 作成者 : saito
 * 作成日 : 2013/10/10
 * 最終更新日：yyyy/mm/dd
 */
require_once 'DBConnector.php';

/**
 * 会員テーブルアクセスクラス
 *
 */
class UserModel {
	protected $db;

	/**
	 * コンストラクター
	 */
	public function __construct($db) {
		$this->db = $db;
	}

	/**
	 * 会員検索処理
	 *
	 * @param unknown $user
	 * @param unknown $pass
	 * @throws PDOException
	 * @return boolean
	 */
	public function select($user, $pass) {

		$status = false;
		try {
			$sth = $this->db->prepare ( 'select * from user_regist where user = :inUser and pass = :inPass' );
			$sth->bindParam ( ":inUser", $user );
			$sth->bindParam ( ":inPass", $pass );
			$sth->execute ();
			$sth->setFetchMode ( PDO::FETCH_ASSOC );

			while ($row = $sth->fetch ()) {
				$_SESSION['user'] = $user;
				$_SESSION['fullname'] = $row['fullname'];
				$_SESSION['last'] = $row['last'];
				$_SESSION['priv'] = $row['priv'];

				$sth = $this->db->prepare ( 'update user_regist set last=now() where user = :inUser' );
				$sth->bindParam ( ":inUser", $user );
				$sth->execute ();
				$status = true;
			}
			return $status;

		} catch ( PDOException $e ) {
			$db->rollBack ();
			throw new PDOException($e);
		}
	}

	/**
	 * 会員登録処理
	 *
	 * @param unknown $user
	 * @param unknown $pass
	 * @param unknown $fullname
	 * @param unknown $priv
	 * @throws PDOException
	 * @return boolean
	 */
	public function insert($user, $pass, $fullname, $priv) {

		$status = false;
		try {
			$sth = $this->db->prepare ( 'insert into user_regist (user, pass, fullname, priv, last) values' .
										' (:inUser, :inPass, :inFullname, :inPriv, now())' );
			$sth->bindParam ( ":inUser", $user );
			$sth->bindParam ( ":inPass", $pass );
			$sth->bindParam ( ":inFullname", $fullname );
			$sth->bindParam ( ":inPriv", $priv );
			$sth->execute ();
			$status = true;

			return $status;
		} catch ( PDOException $e ) {
			$db->rollBack ();
			throw new PDOException($e);
		}
	}

	/**
	 * 会員削除処理
	 *
	 * @param unknown $user
	 * @throws PDOException
	 * @return boolean
	 */
	public function delete($user) {

		$status = false;
		try {
			$sth = $this->db->prepare ( "delete from user_regist where user = :inUser" );
			$sth->bindParam ( ":inUser", $user );
			$sth->execute ();
			$status = true;

			return $status;
		} catch ( PDOException $e ) {
			$db->rollBack ();
			throw new PDOException($e);
		}
	}

}