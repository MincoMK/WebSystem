<?php
$db = include("db.php");
$token = $_GET['token'];

if (!isset($token)) {
  die("Do Not Hack");
}

$sql = "UPDATE `account` SET verified=1 WHERE token='{$token}'";
$sql1 = "SELECT * FROM `account` WHERE TOKEN='{$token}'";

mysqli_query($db, $sql);
$res = mysqli_query($db, $sql1);

$row = mysqli_fetch_array($res);
$bpw = base64_encode($row['pw']);

header("Location: login.php?email={$row['email']}&pw={$bpw}")
?>
