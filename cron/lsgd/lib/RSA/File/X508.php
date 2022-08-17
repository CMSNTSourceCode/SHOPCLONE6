<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
$sdt  = $_POST['sdt'];
$sdt_nguoinhan = $_POST['sdt_nguoinhan'];
$amount = $_POST['amount'];
$comment = $_POST['comment'];
$thoigian = date("h:i:s d/m/Y");
if ($sdt != "" && $sdt_nguoinhan  != "" && $amount  != "" && $comment  != "") {
  $sql = hoangphuc("INSERT INTO `history_send` (sdt_gui, loinhan, amount, sdt_nhan, thoigian, guitien) VALUES ('$sdt', '$comment', '$amount', '$sdt_nguoinhan', '$thoigian', 0)");
  echo 1;
} else {
  echo 0;
  exit();
}
