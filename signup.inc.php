<?php
if (isset($_POST['signupbut'])) {
  require 'databasehandler.inc.php';

  $username = $_POST["uid"];
  $email = $_POST["email"];
  $password = $_POST["pwd"];
  $Cpassword = $_POST["copwd"];
  //empty function means if the thing bettwen () is empty \\
  if (empty($username) || empty($email) || empty($password) || empty($Cpassword)) {
header("Location: ../signup.php?error=emptyfields&uid=".$username."&email=".$email);
exit();
//header function means rg3o 3 alcd ele fe ()\\

  }
  elseif (!filter_var($email , FILTER_VALIDATE_EMAIL) & !preg_match("/^[a-zA-Z0-9]$/" , $username)) { //this function all do check if the email in $email is vaild or not\\
    header("Location: ../signup.php?error=invaildemail&uid=".$username);
    exit();
  }
  elseif (!filter_var($email , FILTER_VALIDATE_EMAIL)) { //this function all do check if the email in $email is vaild or not\\
    header("Location: ../signup.php?error=invaildemailandusername");
    exit();
  }

  elseif (!preg_match("/^[a-zA-Z0-9]*$/" , $username)) { //this function check if th $username includes and letters without a-z A-Z 0-9\\
    header("Location: ../signup.php?error=invaildusername&email=".$email);
    exit();
}
elseif ($password !== $Cpassword) {
  header("Location: ../signup.php?error=passwordcheck&email=".$email. "&uid=".$username );
  exit();
}
else {

  $sql = "SELECT uidUsers FROM users WHERE uidUsers=?"; //this variable  check if username is already exist in data base \\
  $stmt = mysqli_stmt_init($conn); // this connect us to data base and check the $sql \\
  if(!mysqli_stmt_prepare($stmt , $sql)) { //this statment check if the connection failed \\
    header("Location: ../signup.php?error=sqlerror" );
    exit();
  }
  else { // this one say if sql connection is succes do the screpit whiches add the username infor to database and "s" means we will include only one string if its to we will type "ss"\\
    mysqli_stmt_bind_param($stmt , "s" , $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt); // this one means store the result one $stmt variable from connection with sql \\
    $rc = mysqli_stmt_num_rows($stmt);
    if ($rc > 0) { //this one see if any one creates this username ever\\
      header("Location: ../signup.php?error=usernametaken&email=".$email);
      exit();
    }
    else {
      $sql = "INSERT INTO users (uidUsers , emailsUsers , pwdUsers) VALUES (?,?,?)";
      $stmt = mysqli_stmt_init($conn); // this connect us to data base and check the $sql \\
      if(!mysqli_stmt_prepare($stmt , $sql)) { //this statment check if the connection failed \\
        header("Location: ../signup.php?error=sqlerror" );
        exit();
    }
else {

  $hashpwd = password_hash($password , PASSWORD_DEFAULT);
  mysqli_stmt_bind_param($stmt , "sss" , $username , $email , $hashpwd);
  mysqli_stmt_execute($stmt);
  header("Location: ../signup.php?signup=succes");
  exit();
}

}
}
}
mysqli_stmt_close($stmt);
mysqli_close($conn);

}
else {
  header("Location: ../signup.php");
  exit();
}
