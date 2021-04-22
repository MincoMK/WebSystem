<?php
include($_SERVER['DOCUMENT_ROOT'] . "/_apis/mail/send.php");
$db = include("db.php");

$redirectURI = "login.php";
$__EMAIL_VERIFICATION_URI__ = "https://main.minco.kro.kr/a/enable.php";

$cError = "";
$cSuccess = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $email = $_POST['email'];
  $pw = $_POST['pw'];
  $username = $_POST['username'];
  if (!isset($email) || !isset($pw) || !isset($username)) {
    echo "DO NOT HACK!";
    exit;
  }

  $email = verifyEmail($email);
  $pw = verifyPassword($pw);
  $username = verifyUsername($username);

  $res0 = mysqli_query($db, "SELECT * FROM `account` WHERE email='{$email}'");
  $res1 = mysqli_query($db, "SELECT * FROM `account` WHERE username='{$username}'");

  // print_r(array($res0, $res1));

  $token = "";

  $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890........";
  $charsLength = strlen($chars);

  for ($i = 0; $i < 20; $i++) {
    $token .= $chars[rand(0, $charsLength -1)];
  }

  if ($res0->num_rows == 0 && $res1->num_rows == 0) {
    $sql = "INSERT INTO `account`(token, email, pw, username) VALUES ('{$token}', '{$email}', '{$pw}', '{$username}')";
    mysqli_query($db, $sql);
    // clientSuccess();
    $bpw = base64_encode($pw);

    $mail = "
    <a href='{$__EMAIL_VERIFICATION_URI__}?token={$token}' style='color: yellow'>Verify</a>
    ";

    MincoMail::send([ "to" => $email, "title" => "Verify Email", "content" => $mail, "name" => "No Reply" ]);

    header("Location: {$redirectURI}?email={$email}&pw={$bpw}");
  } else {
    clientError("Account Exists!");
  }
}

function clientSuccess($msg = "Successfully Registered!") {
  global $cSuccess;
  $cSuccess = $msg;
}

function clientError($msg = "Something Went Wrong In Your Client...") {
  global $cError;
  $cError = $msg;
}

function verifyEmail($e) {
  return $e;
  // TODO: Need To Make Something
}

function verifyPassword($e) {
  return $e;
  // TODO: Need To Make Something
}

function verifyUsername($e) {
  return $e;
  // TODO: Need To Make Something
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/fontawesome.css" integrity="sha384-eHoocPgXsiuZh+Yy6+7DsKAerLXyJmu2Hadh4QYyt+8v86geixVYwFqUvMU8X90l" crossorigin="anonymous"/>
        <title>Register</title>
    </head>
    <style media="screen">
      * {
        box-sizing: border-box;
      }

      .fm {
        margin: 45px;
      }

      .ms {
        color: white;
        background: gray;
        width: 140px;
        height: 70px;
        padding: 10px;
      }

      .clientError {
        color: red;
        margin-top: 25px;
      }

      .clientSuccess {
        color: lime;
      }

      .login {
        margin-top: 20px;
      }

      .mg {
        margin-top: 10px;
      }

      .register {
        margin-top: 20px;
      }

      #pwConfirmError {
        color: red;
      }

      #usernameError {
        color: red;
      }

      #emailHelp {
        color: gray;
      }

      #checkboxError {
        color: red;
        display: none;
      }
    </style>
    <body>
      <form class="fm" method="post">
        <h1>Register</h1>
        <small class="">We need some informations for verify you are human and save who are you</small>
        <div class="mg"></div>
        <div class="form-group">
          <label for="exampleInputEmail1">Email</label>
          <input type="email" autocomplete="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
          <small id="emailHelp" class="form-text">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
          <label for="examSign UputPassword1">Password</label>
          <input type="password" autocomplete=" new-password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="pw">
          <small id="pwHelp" class="form-text text-muted">Do not share your password with anyone else.</small>
        </div>
        <div class="form-group">
          <label for="examplePassword2">Confirm Password</label>
          <input type="password" autocomplete="new-password" class="form-control" id="exampleInputPassword2" placeholder="Password">
          <small id="pwConfirmError" class="form-text"></small>
        </div>
        <div class="form-group">
          <label for="exampleUsername1">Username</label>
          <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Username" name="username">
          <small id="usernameError" class="form-text"></small>
        </div>
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1"><a href="https://main.minco.kro.kr/privacy">I Accept The Privacy Policy</a></label>
          <small class="form-text" id="checkboxError">Please Accept The Privacy Policy</small>
        </div>
        <small class="form-text"><span class="text-muted">Already have account?</span> <a href="login.php">Login now</a></small>
        <button type="button" class="btn btn-primary register" id="signUp">Register</button>
        <div class="clientError"><small class="clientErrorSmall"><?= $cError ?></small></div>
        <div class="clientSuccess"><small class="clientSuccessSmall"><?= $cSuccess ?></small></div>
      </form>
      <script type="text/javascript" src="signupjs.js"></script>
      <script type="text/javascript" src="signupjs1.js"></script>
    </body>
</html>
