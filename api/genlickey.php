<?php
$mysqli = new mysqli("localhost","maihuyba_license","maihuyba_license","maihuyba_license");
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
$sql = "SELECT `licensekey` FROM `mod_licensing` WHERE `status` = 'Reissued'";
$result = mysqli_query($mysqli,$sql);
$row = mysqli_fetch_array($result, MYSQLI_NUM);
printf ("%s", $row[0]);
?>