<?php
/**
 * 概要   : 商品出品モデル
 *          exhibit_registテーブルへのアクセス機能を提供する。
 * 作成者 : saito
 * 作成日 : 2013/10/10
 * 最終更新日：yyyy/mm/dd
 */

require_once 'DBConnector.php';

/**
 * 出品テーブルアクセスクラス
 *
 */
class ExhibitModel {
	protected $db;

	/**
	 * コンストラクター
	 */
	public function __construct($db) {
		$this->db = $db;
	}

	/**
	 * 出品データ登録処理
	 *
	 *
	 * @param unknown $user
	 * @param unknown $kind
	 * @param unknown $item
	 * @param unknown $start_price
	 * @param unknown $current_price
	 * @param unknown $start_date
	 * @param unknown $end_dat
	 * @throws PDOException
	 * @return boolean
	 */
	public function insert($user, $kind, $item, $start_price, $current_price, $start_date, $end_date) {

		$status = false;
		try {
			$sth = $this->db->prepare ( 'insert into exhibit_regist ' .
					' ( user, kind, item, start_price, current_price, start_date, end_date ) values' .
					' (:inUser, :inKind, :inItem, :inStart_price, :inCurrent_price, :inStart_date, :inEnd_date)' );
			$sth->bindParam ( ":inUser", $user );
			$sth->bindParam ( ":inKind", $kind );
			$sth->bindParam ( ":inItem", $item );
			$sth->bindParam ( ":inStart_price", $start_price );
			$sth->bindParam ( ":inCurrent_price", $current_price );
			$sth->bindParam ( ":inStart_date", $start_date );
			$sth->bindParam ( ":inEnd_date", $end_date );
			$sth->execute ();
			$status = true;

			return $status;
		} catch ( PDOException $e ) {
			$this->db->rollBack ();
			throw new PDOException($e);
		}
	}

	/**
	 * 出品データ更新処理（現在の金額）
	 *
	 * @param unknown $current_price
	 * @return boolean
	 */
	public function update($id, $price) {

		$status = false;
		try {
			$sth = $this->db->prepare ( 'update exhibit_regist set current_price = :inPrice where id = :inID' );

			$sth->bindParam ( ":inID", $id );
			$sth->bindParam ( ":inPrice", $price );
			$sth->execute ();
			$status = true;

			return $status;
		} catch ( PDOException $e ) {
			$this->db->rollBack ();
			throw new PDOException($e);
		}
	}

	/**
	 * 出品データ検索処理
	 *
	 * @param unknown $id
	 * @throws PDOException
	 * @return array
	 */
	public function select($id) {

		try {
			$sth = $this->db->prepare ( "select * from exhibit_regist where id = :inId and end_date > now()" );
			$sth->bindValue ( ':inId', $id );
			$sth->execute ();
			$sth->setFetchMode ( PDO::FETCH_ASSOC );
			$arr = array ();
			while ( $row = $sth->fetch () ) {
				$arr [] = $row;
			}
			return $arr;
			} catch ( PDOException $e ) {
				throw new PDOException($e);
			}
	}

	public function selectPrice($id) {

		try {
			$sth = $this->db->prepare ( "select * from exhibit_regist where id = :inId and end_date > now()" );
			$sth->bindValue ( ':inId', $id );
			$sth->execute ();
			$sth->setFetchMode ( PDO::FETCH_ASSOC );
			$current_price = 0;
			while ( $row = $sth->fetch () ) {
				$current_price = $row['current_price'];
			}
			return $current_price;

		} catch ( PDOException $e ) {
			throw new PDOException($e);
			return $current_price;
		}

	}

	/**
	 * 出品データ一覧取得処理
	 *
	 * @param unknown $user
	 * @throws PDOException
	 * @return array
	 */
	public function select2($user) {

		try {
			$sth = $this->db->prepare ( "select * from exhibit_regist where user = :inUser and end_date > now()" );
			$sth->bindValue ( ':inUser', $user );
			$sth->execute ();
			$sth->setFetchMode ( PDO::FETCH_ASSOC );
			$arr = array ();
			while ( $row = $sth->fetch () ) {
				$arr [] = $row;
			}
			return $arr;
		} catch ( PDOException $e ) {
			throw new PDOException($e);
		}
	}

	/**
	 * 出品商品全件検索処理
	 *
	 * @param unknown $user
	 * @throws PDOException
	 * @return array
	 */
	public function select3() {

		try {
			$sth = $this->db->prepare ( "select * from exhibit_regist where end_date > now()" );
			$sth->execute ();
			$sth->setFetchMode ( PDO::FETCH_ASSOC );
			$arr = array ();
			while ( $row = $sth->fetch () ) {
				$arr [] = $row;
			}
			return $arr;
		} catch ( PDOException $e ) {
			throw new PDOException($e);
		}
	}

	/**
	 * 出品商品種別検索処理
	 *
	 * @param unknown $kind
	 * @throws PDOException
	 * @return array
	 */
	public function select4($kind) {

		try {
			$sth = $this->db->prepare ( "select * from exhibit_regist where kind = :inKind and end_date > now()" );
			$sth->bindValue ( ':inKind', $kind );
			$sth->execute ();
			$sth->setFetchMode ( PDO::FETCH_ASSOC );
			$arr = array ();
			while ( $row = $sth->fetch () ) {
				$arr [] = $row;
			}
			return $arr;
		} catch ( PDOException $e ) {
			throw new PDOException($e);
		}
	}

	/**
	 * 入札商品一覧取得処理
	 *
	 * @param unknown $user
	 * @throws PDOException
	 * @return array
	 */
	public function select5($user) {

		try {
			$sth = $this->db->prepare ( "select user,kind,item,start_price,bidder,price,end_date,dob " .
										" from exhibit_regist e,bid_regist b where " .
										" e.id = b.id and bidder = :inUser and end_date > now()" );
			$sth->bindValue ( ':inUser', $user );
			$sth->execute ();
			$sth->setFetchMode ( PDO::FETCH_ASSOC );
			$arr = array ();
			while ( $row = $sth->fetch () ) {
				$arr [] = $row;
			}
			return $arr;
		} catch ( PDOException $e ) {
			throw new PDOException($e);
		}
	}
}