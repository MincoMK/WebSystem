<?php
ini_set("display_errors", 1);
session_start();
$db = include("db.php");

$_AF = array("email" => "", "pw" => ""); // AutoFill

$clientError = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $email = $_POST['email'];
  $pw = $_POST['pw'];

  if (!isset($email) || !isset($pw)) {
    die("Do Not Hack");
  }

  $sql = "SELECT * FROM `account` WHERE email='{$email}' AND pw='{$pw}'";
  $res = mysqli_query($db, $sql);

  if ($res->num_rows == 0) {
    global $clientError;
    $clientError = "Email Or Password Is Incorrect";
  } elseif ($res->num_rows == 1) {
    // TODO: Main Code
    global $clientError;
    $arr = mysqli_fetch_array($res);
    if ($arr['verified'] == 0) {
      $clientError = "Email not verified. Check your mail!";
    } else {
      $username = $arr["username"];
      $token = $arr["token"];
      $token = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($token)))));
      $_SESSION['USERNAME'] = $username;
      $_SESSION['TOKEN'] = $token;
      $_SESSION['EMAIL'] = $email;
      $_SESSION['LOGIN'] = true;
      setcookie("USERNAME", $username, time() + 3600, "/");
      setcookie("TOKEN", $token, time() + 3600, "/");
    }
  } else {
    global $clientError;
    $clientError = 'Backend Error, Please Contact To Staff. (Minco: <a href="mailto:mail@drchi.co.kr">mail@drchi.co.kr <a href="tel:050713313971">050713313971 - Korea</a>)';
  }
} elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
  // AutoFill
  $_AF['email'] = $_GET['email'];
  $_AF['pw'] = @base64_decode($_GET['pw']);
  if (!$_AF['pw']) {
    $_AF['pw'] = "";
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/fontawesome.css" integrity="sha384-eHoocPgXsiuZh+Yy6+7DsKAerLXyJmu2Hadh4QYyt+8v86geixVYwFqUvMU8X90l" crossorigin="anonymous"/>
    <title>Login</title>
  </head>
  <style media="screen">
    .fm {
      margin: 45px;
    }

    .clientError {
      color: red;
      margin-top: 25px;
    }

    .ii {
      <?= $clientError == "" ? "" : "border: 1px solid #ffabab;" ?>
    }

    .login {
      margin-top: 20px;
    }

    .mg {
      margin-top: 10px;
    }
  </style>
  <body>
    <form class="fm" method="post">
      <h1>Login</h1>
      <small class="">We need your <b>email</b>, <b>password</b> to identify who are you</small>
      <div class="mg"></div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" id="email" name="email" class="form-control ii" placeholder="Enter email" value="<?= $_AF['email'] ?>">
      </div>
      <div class="form-group">
        <label for="pw">Password</label>
        <div class="input-group">
          <input type="password" id="pw" name="pw" class="form-control ii" placeholder="Password" value="<?= $_AF['pw'] ?>">
        </div>
      </div>
      <small class="form-text"><span class="text-muted">Don't have account?</span> <a href="register.php">Register now</a></small>
      <button type="submit" class="btn btn-primary login">Login</button>
      <div class="clientError"><small><?= $clientError ?></small></div>
    </form>
  </body>
</html>
