<?php
function getDb() {
  $dsn = 'mysql:dbname=furction; host=127.0.0.1';
  $usr = 'root';
  $passwd = 'mysql';

  try {
    $db = new PDO($dsn, $usr, $passwd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec('SET NAMES utf8');
  } catch (PDOException $e) {
    die("接続エラー：{$e->getMessage()}");
  }
  return $db;
}
