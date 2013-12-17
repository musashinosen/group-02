<?php
/**
 * 概要         : logout する
 * 作成者       : saitoh
 * 作成日       : 2013/10/08
 * 最終更新日   : 2013/10/11
 */
session_start();
unset($_SESSION['user']);
header('Location: loginController.php');
exit;
?>
