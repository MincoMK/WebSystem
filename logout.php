<?php
session_start();
unset($_SESSION['LOGIN']);
unset($_SESSION['EMAIL']);
unset($_SESSION['USERNAME']);
unset($_SESSION['TOKEN']);

$rURL = $_GET['redirectURL'];

if (isset($rURL)) {
  header("Location: {$rURL}");
} else {
  header("Location: /welcome.php");
}
?>
