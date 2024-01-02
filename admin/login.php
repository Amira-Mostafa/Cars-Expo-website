
<?php
session_start();
if($_SERVER["REQUEST_METHOD"] === "POST"){
  include_once("includes/conn.php");

//chech login -->
if (!empty($_POST['loginUser'])) {
try{
  $username = $_POST["Username"];
  $password = $_POST["Password"];
 
  $sql = "SELECT * FROM `userstable` WHERE `username` = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$username]);
  if($stmt->rowCount() > 0){
      $result = $stmt->fetch();
      $activity = $result["activity"];    
      $hash = $result["password"];
// checking pass is correct
      $verify = password_verify($password, $hash);
      if($verify){
          $_SESSION["logged"] = true;
// checking if the user is active so we direct him to admin if not he is directed to index
          if ($activity == 'Yes') {
            header("Location: users.php?id=" . $result['id']);
            die();
          }else{
            header("Location: /gradProject/index.php?id=" . $result['id']);
            die();
          }
        }else{
          echo "Password is incorrect";}
    }else{
          echo "Enter a valid username";
    }

}catch(PDOException $e){
      echo "Connection failed: " . $e->getMessage();
} 
}
// register --> 
if (!empty($_POST['submitnewUser'])) {
  try{
    $fullname = $_POST["Fullname"];
    $username = $_POST["Username"];
    $email = $_POST["Email"];
    $password = password_hash($_POST["Password"], PASSWORD_DEFAULT);
      $sql = "INSERT INTO `userstable`(`fullname`, `username`, `email`, `password`) VALUES (?, ?, ?, ?)";
      $st = $conn->prepare($sql);
      $st->execute([$fullname, $username, $email, $password]);
// directing any new registered user to index
      header("Location: /gradProject/index.php");
      die();

  }catch(PDOException $e){
      echo "Connection failed: " . $e->getMessage();
  }
}
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Rent Car Admin | Login/Register</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>
  
  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="" method="POST" id="form1">
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" name="Username" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password"  name="Password" required="" />
              </div>
              <div>       
              <input type="submit" name="loginUser" class="btn btn-default submit"/>

                <a class="reset_pass" href="#">Lost your password?</a>
              </div>
              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-car"></i></i> Rent Car Admin</h1>
                  <p>©2016 All Rights Reserved. Rent Car Admin is a Bootstrap 4 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
       
        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form action="" method="POST">
              <h1>Create Account</h1>
              <div>
                <input type="text" class="form-control" placeholder="Fullname" name="Fullname" required="" />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Username" name="Username" required="" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Email" name="Email" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" name="Password" required="" />
              </div>
              <div>
              
                <input type="submit" name="submitnewUser" class="btn btn-default submit"/>

              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-car"></i></i> Rent Car Admin</h1>
                  <p>©2016 All Rights Reserved. Rent Car Admin is a Bootstrap 4 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
