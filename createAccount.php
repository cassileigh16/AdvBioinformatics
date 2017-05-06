<?php
  include("config.php");
  session_start();
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    //after clicking "create account"
    if (!$db)
    {
      die("Connection Failed: " . mysqli_connect_error());
    }

    $myusername=$_POST['myUs3rnam3'];
    $mypassword=$_POST['myPassw0rd'];
    $confirmpassword=$_POST['myPassw0rd2'];

    $usernameQuery="SELECT ID FROM patients WHERE usernam3 = '$myusername'";
    $resultUserQuery=mysqli_query($db, $usernameQuery);
    //if there are no users with that username
    if(!($rowsUsers=mysqli_num_rows($resultUserQuery)))
    {
      //and the passwords match
      if($mypassword==$confirmpassword)
      {
        //create a user ID, username, and password
        $xID=uniqid();
        //insert into patients
        $createQuery= "INSERT INTO patients (ID, usernam3, passcod3) VALUES ('$xID', '$myusername', '$mypassword')";
        $create=mysqli_query($db, $createQuery);
        /*if (mysqli_query($db, $createQuery))
        {
          echo "New record created successfully";
        }
        else
        {
        echo "Error: " . $createQuery . "<br>" . mysqli_error($db);
        }*/
        //login using that information
        $query = "SELECT ID FROM patients WHERE usernam3 = '$myusername' AND passcod3='$mypassword'";
        $resultOfQuery = mysqli_query($db, $query);
        $rows=mysqli_num_rows($resultOfQuery);
        if($rows>0)
        {
          $_SESSION['myUsername'] = $myusername;
          header("location: mainPage.php");
        }
      }
      //if passwords do not match
      else
      {
        $passError= "The passwords do not match; please try again";
        echo $passError;
      }
    }
    //if there is a user with that username
    else
    {
      $userError = "This username is already in use; please try again";
      echo $userError;
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
                  placeholder = "&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;"/><br>
          <label><b>Confirm Password: </b></label><br>
          <input type = "password"
                 id = "myPassw0rd2"
                 name = "myPassw0rd2"
                 placeholder = "&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;"/>
        </p>
      </center>
    </fieldset>
    <center>
    <input type="submit" name="Create Account" value="Create Account"></center>
    </form>
  </body>
</html>
