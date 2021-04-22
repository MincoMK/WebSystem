const pwd1 = document.querySelector("#exampleInputPassword1");
const pwd2 = document.querySelector("#exampleInputPassword2");
const pwdI1 = document.querySelector("#pwConfirmError");
const email1 = document.querySelector("#exampleInputEmail1");
const emailHelp = document.querySelector("#emailHelp");
const username = document.querySelector("#exampleInputUsername1");
const usernameError = document.querySelector("#usernameError")
const check = document.querySelector("#exampleCheck1");
const checkError = document.querySelector("#checkboxError");
const signBtn = document.querySelector("#signUp");
const form = document.querySelector(".fm");

const normalEmailHelp = "We'll never share your email with anyone else.";

const border1 = "1px solid #ffabab";
const basicBorder = "1px solid #ced4da";
const errorColor = "red";
const normalBorder = "1px solid #ced4da";
signBtn.addEventListener("click", signUp);

function signUp(e) {
  let error = false;
  let pwdError = false;

  if (pwd1.value != pwd2.value) {
    pwdConfirmError();
    error = true;
    pwdError = true;
  }

  if (pwd1.value.length < 8) {
    pwdOutOfCompliance();
    error = true;
    pwdError = true;
  }

  if (email1.value.length < 5) {
    emailMustOver5Chars();
    error = true;
  } else clearEmailError();

  if (username.value.length < 2) {
    usernameMustOver2Chars();
    error = true;
  } else clearUsernameError();

  if (!check.checked) {
    checkError.style.display = "block";
    error = true;
  } else checkError.style.display = "none";

  if (!pwdError) {
    clearPwdError();
  }

  if (error) return;

  form.submit();
}

function pwdConfirmError() {
  showPwdError("Password Does Not Match")
}

function pwdOutOfCompliance() {
  showPwdError('Password Is Out Of Compliance <a href="javascript:pwdCompliance()">?</a>')
}

function showPwdError(message) {
  pwd1.style.border = border1;
  pwd2.style.border = border1;

  pwdI1.innerHTML = message;
  pwdI1.style.color = errorColor;
}

function clearPwdError() {
  pwd1.style.border = normalBorder;
  pwd2.style.border = normalBorder;
  pwdI1.innerHTML = "";
}

function emailMustOver5Chars() {
  showEmailError('Email Must Over 5 Chars! <a href="javascript:email5Info()">?</a>');
}

function showEmailError(message) {
  email1.style.border = border1;
  emailHelp.innerHTML = message;
  emailHelp.style.color = errorColor;
}

function clearEmailError() {
  email1.style.border = normalBorder;
  emailHelp.innerHTML = "";
  emailHelp.style.color = "gray";
}

function usernameMustOver2Chars() {
  showUsernameError("Username Must Over 2 Chars!");
}

function showUsernameError(message) {
  username.style.border = border1;
  usernameError.innerHTML = message;
  usernameError.style.color = errorColor;
}

function clearUsernameError() {
  username.style.border = normalBorder;
  usernameError.innerHTML = "";
  usernameError.style.color = "gray";
}
