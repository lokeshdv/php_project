<?php
if (isset($_post['submit']))
{
  include("dbh.php");
  $usename=$_post['uid'];
  $email=$_post['email'];
  $pwd=$_post['pwd'];
  $pwdr=$_post['pwd-r'];

  if (empty($username)||empty($email)||empty($pwd)||empty($pwdr))
  {
    header("location:signup.php?error=emptyfields&uid=".$username."&email=".$email."&pwd=".$pwd."&pwdr=".$pwdr);
    exit();
  }
  elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)&& !preg_match("/^[a-zA-Z0-9]*$/"))
  {
    header("location:signup.php?error=checkuid&email&email=".$email."&uid".$username);
    exit();
  }
  elseif (strlen($pwd)>6)
  {
    header("location:signup.php?error=checkpwd&too&short");
    exit();
  }
  elseif ($pwd !== $pwdr)
  {
    header("location:signup.php?error=checkpwd&both");
    exit();
  }
  else
  {
      $sql="SELECT * FROM users where useruid=? or useremail=?";
      $stmt=mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt,$sql))
      {
          header("location:signup.php?error=sqlerror");
          exit();
      }
      else
      {
        mysqli_stmt_bind_param($stmt,"ss",$username,$email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if ($resultcheck>0)
        {
          header("location:");
          exit();
        }
        else
        {
          $sql="INSERT INTO users whrere useruid,usereamil,userpwd";
          $stmt=mysqli_stmt_init($conn);
          if (mysqli_stmt_preprare($stmt,$sql))
          {
              header("location:");
              exit();
          }
          else {
            mysqli_stmt_bind_param($stmt,"sss",$username,$email,$pwd);
          }
        }
      }

      }
  }
}




?>
