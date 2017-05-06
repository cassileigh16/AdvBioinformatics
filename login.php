<?php
  include("config.php");
  session_start();
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
      // username and password sent from form
      if (!$db)
      {
        die("Connection Failed: " . mysqli_connect_error());
      }
      $myusername=$_POST['myUs3rnam3'];
      $mypassword=$_POST['myPassw0rd'];
      //see if username and password are in the patient data
      $query = "SELECT ID FROM patients WHERE usernam3 = '$myusername' AND passcod3='$mypassword'";
      $resultOfQuery = mysqli_query($db, $query);
      $rows=mysqli_num_rows($resultOfQuery);
      //if there is a user, login
      if($rows>0)
      {
         $_SESSION['myUsername'] = $myusername;
         header("location: mainPage.php");
      }
      //else, return error
      else
      {
        $error= "Your Email or Password is invalid";
        echo $error;
      }
  }
?>
<html lang = "en">
  <head>
    <title>MedMinder</title>
    <!---<link rel="icon" type="image/ico" href="C:\Users\Cassandra\OneDrive\Documents\BIIN\Aspirin.ico"> --->
    <link rel="icon" type="image/ico" href="favicon.ico">
    <meta charset = "UTF-8" />
    <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">
  </head>
  <style>
    body
    {
      background-image: url(http://www.pakistankakhudahafiz.com/pkkhnew/wp-content/uploads/2016/07/medicine-exports.jpg);
    }
    p
    {
      Font-family: 'Noto Serif', serif;
      Font-size: 20px;
      color: #ffffff;
      text-shadow: 1px 0 0 #000, 0 -1px 0 #000, 0 1px 0 #000, -1px 0 0 #000;
    }
    button
    {
      width: 125px;
      height: 30px;
      margin: 5px;
      padding: 5px;
    }
  </style>

  <body>
    <br><br>
    <center>
    <p style="Font-size:60px"><b>MedMinder</b></p>
    <form action="" method="post">
      <fieldset style="width:270px";>
        <!--creates the lines-->
        <p>
          <label><b>Username: </b></label><br>
          <input type = "text"
                 id = "myUs3rnam3"
                 name= "myUs3rnam3"
                 style="Font-family:'Noto Serif', serif; Font-size: 15px; color:#000000"
                 placeholder = "Enter username here" /><br>

          <label><b>Password: </b></label><br>
          <input type = "password"
                  id = "myPassw0rd"
                  name = "myPassw0rd"
                  placeholder = "&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" />
        </p>
      </center>
    </fieldset>
    <center>
    <input type="submit" name="Login" value="Login"></center>
    </form>
    <!---if necessary to create account, click button--->
    <form action="createAccount.php" method="">
      <center>
        <br>
        <input type="submit" name="Create Account" value="Create Account">
      </center>
    </form>
  </body>
</html>
