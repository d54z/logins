<?php

if (isset($_POST['login-submit'])) {
require 'databasehandler.inc.php';
$mailuid = $_POST['USoEM'];
$password = $_POST['password'];
if (empty($mailuid) ||empty($password)) {
  header("Location: ../index.php?error=emptyfields");
  exit();
}
else {
  $sql = "SELECT * FROM users WHERE uidUsers=?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt , $sql)) {
    header("Location: ../index.php?error=sqlerror");
    exit();
  }
  else {
    mysqli_stmt_bind_param($stmt, "s", $mailuid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
      $pwdcheck = password_verify($password , $row['pwdUsers']); //this func take the password from the sql and the password user types and check if it match \\
      if ($pwdcheck == false) {
        header("Location: ../index.php?error=wrongpassword");
        exit();
      }
      elseif ($pwdcheck == true) { //this function chevck if all true will login into the website\\
        session_start();
       $_SESSION['userId'] = $row['idUsers'];
       $_SESSION['userUid'] = $row['uidUsers'];
       header("Location: ../index.php?login=succed");
       exit();
      }
      else {
        header("Location: ../index.php?error=wrongpassword");
        exit();
      }
    }
    else {
      header("Location: ../index.php?error=nouser");
      exit();
    }
  }
}
}
else {
  header("Location: ../index.php");
  exit();
}
