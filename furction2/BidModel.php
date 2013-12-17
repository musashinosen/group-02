<?php
/**
 * 概要   : 入札モデル
 *          bid_registテーブルへのアクセス機能を提供する。
 * 作成者 : saito
 * 作成日 : 2013/10/10
 * 最終更新日：yyyy/mm/dd
 */

require_once 'DBConnector.php';

/**
 * 入札テーブルアクセスクラス
 *
 */
class BidModel {
	protected $db;

	/**
	 * コンストラクター
	 */
	public function __construct($db) {
		$this->db = $db;
	}

	/**
	 * 入札データ検索処理
	 *
	 * @param unknown $id
	 * @throws PDOException
	 * @return boolean
	 */
	public function select($id) {
		try {
			$sth = $this->db->prepare ( "select * from bid_regist where id = :inId order by price desc" );
			$sth->bindParam ( ":inId", $id );
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
	public function select_by_user($user) {

		try {
			$sth = $this->db->prepare ( "select" .
					" e.id, e.user, e.kind, e.item, e.start_price, b.bidder, b.price, e.end_date, b.dob" .
					" from exhibit_regist e, bid_regist b " .
					" where e.id = b.id and b.bidder = :inUser and e.end_date > now()" );
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

	public function selectPrice($id) {
		$price=0;

		try {
			$sth = $this->db->prepare ( "select * from bid_regist where id = :inId " );
			$sth->bindParam ( ":inId", $id );
			$sth->execute ();
			$sth->setFetchMode ( PDO::FETCH_ASSOC );

			while ( $row = $sth->fetch () ) {
				$price = $row['current_price'];//現在の金額
			}

		} catch ( PDOException $e ) {
			$err = $_SESSION['errmsg'] = "システムエラーが発生しました。管理者に連絡してください。";
		}

		return price;
	}

	/**
	 * 入札データ登録処理
	 *
	 * @param unknown $id
	 * @param unknown $bidder
	 * @param unknown $price
	 * @throws PDOException
	 * @return boolean
	 */
	public function insert($id, $bidder, $price) {

		$status = false;
		try {
			$sth = $this->db->prepare ( "insert into bid_regist (id , bidder, price, dob)" .
										" values ( :inId , :inBidder, :inPrice, now())" );
			$sth->bindParam ( ":inId", $id );
			$sth->bindParam ( ":inBidder", $bidder );
			$sth->bindParam ( ":inPrice", $price );
			$sth->execute ();
			$status = true;

			return $status;
		} catch ( PDOException $e ) {
			$db->rollBack ();
			throw new PDOException($e);
		}
	}

	/**
	 * 入札データ更新処理
	 *
	 * @param unknown $id
	 * @param unknown $bidder
	 * @param unknown $price
	 * @throws PDOException
	 * @return boolean
	 */
	public function update($id, $bidder, $price) {

		$status = false;
		try {
			$sth = $this->db->prepare ( "update bid_regist set " .
										" bidder = :inBidder, " .
										" price = :inPrice, " .
										" dob = now() where id = :inId" ) ;
			$sth->bindParam ( ":inId", $id );
			$sth->bindParam ( ":inBidder", $bidder );
			$sth->bindParam ( ":inPrice", $price );
			$sth->execute ();
			$status = true;

			return $status;
		} catch ( PDOException $e ) {
			$db->rollBack ();
			throw new PDOException($e);
		}
	}
}