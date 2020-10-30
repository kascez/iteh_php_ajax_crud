<?php
 require "dbBroker.php";
 require "model/user.php";

 session_start();

 if(isset($_POST['username']) && isset($_POST['password'])) {
     $uname=$_POST['username'];
     $password=$_POST['password'];

    $rs = User::logInUser($uname, $password, $conn);


      if($rs->num_rows==1) {
          echo "You have successfully logged in!";
          $_SESSION['user_id'] = $rs->fetch_assoc()['id'];
          header('Location: home.php');
          exit();
      } else {
          //header('Location: index.php');
          echo '<script type="text/javascript">alert("You have entered incorrect password!"); 
                                                window.location.href = "http://localhost/iteh/";</script>';
          exit();
      }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="shortcut icon"  type="image/x-icon" href="img/favicon.ico" />
    <title>Sir i nemir</title>

</head>
<body>
    <div class="login-form">
        <div class="main-div">
            <form method="POST" action="#">
                <h1>SIR I NEMIR</h1>
                <div class="imgcontainer">
                    <img src="img/about-us.png" alt="Avatar" class="avatar">
                </div>

                <div class="container">
                    <input type="text" placeholder="Username" name="username" class="form-control"  required>
                    <input type="password" placeholder="Password" name="password" class="form-control" required>
                    <button type="submit" class="btn btn-primary" name="submit">Prijavi se</button>
                </div>

            </form>
        </div>
    </div>
</body>
</html>