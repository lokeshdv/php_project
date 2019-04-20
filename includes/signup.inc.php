<?php

if (isset($_POST['signup-submit'])) {
include('dbh.php');
  $username=$_POST['uid'];
  $email=$_POST['email'];
  $pwd=$_POST['pwd'];
  $pwdrepeat=$_POST['pwd-repeat'];

  if (empty($username)|| empty($email) || empty($pwd)|| empty($pwdrepeat))
      {
        header("location:../signup.php?error=emptyfields&uid=".$username."&email=".$email);
        exit();
      }
  elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)&& !preg_match("/^[a-zA-Z0-9]*$/",$username))
      {
        header("location:../signup.php?error=invalidemail&uid");
        exit();
      }
  elseif (!filter_var($email,FILTER_VALIDATE_EMAIL))
      {
        header("location:../signup.php?error=invalidemail&uid=".$email);
        exit();
      }
  elseif (!preg_match("/^[a-zA-Z0-9]*$/",$username))
      {
        header("location:../signup.php?error=invalid&uid=".$username);
        exit();
      }
  elseif ($pwd !== $pwdrepeat)
      {
        header("location:../signup.php?error=passwordcheckuid=".$username."&mail".$email);
        exit();
      }
      else
      {
        echo $sql="select * from users where uidusers=? or emailusers=?";
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql))
        {
          header("location:../signup.php?error=sqlerror");
          exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt,"ss",$username,$email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultcheck=mysqli_stmt_num_rows($stmt);
            if ($resultcheck > 0)
            {
              header("location:../signup.php?error=usrtaken&mail=".$email);
              exit();
            }
            else
            {
          echo  $sql="INSERT INTO users (uidusers,emailusers,pwdusers) values (?,?,?)";
                $stmt=mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt,$sql))
                {
                  header("location:../signup.php?error=sqlerror1");
                  exit();
                }
                else
                {
                  $hashpwd=password_hash($pwd,PASSWORD_DEFAULT);
                  mysqli_stmt_bind_param($stmt,"sss",$username,$email,$hashpwd);
                  mysqli_stmt_execute($stmt);
                  header("location:../signup.php?singup=success");
                  exit();
                }
            }
        }
      }
mysqli_stmt_close($stmt);
mysqli_close($conn);
}


 ?>
