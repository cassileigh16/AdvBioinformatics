<?php
  session_start();
  define('DB_SERVER', 'localhost');
  define('DB_USERNAME', 'root');
  define('DB_PASSWORD', 'medMinder8');
  define('DB_DATABASE', 'patientmedinfo');
  $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
  if (!$db)
  {
    die("Connection Failed: " . mysqli_connect_error());
  }

  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
      //change start and end dates so the main page can calculate correctly

        $startDateRaw=$_POST['startDate'];
        $endDateRaw=$_POST['endDate'];

        $startM=substr($startDateRaw, 0, 2);
        $startD=substr($startDateRaw, 3, 2);
        $startY=substr($startDateRaw, 6, 4);
        $startDate=$startY."-".$startM."-".$startD;

        $endM=substr($endDateRaw, 0, 2);
        $endD=substr($endDateRaw, 3, 2);
        $endY=substr($endDateRaw, 6, 4);
        $endDate=$endY."-".$endM."-".$endD;

        //open file and read user and medID
        $fp=fopen("storedInfo.txt", "r");
        $textInfo=fgets($fp, 999);
        $user=substr($textInfo, 0, 13);
        $medID=substr($textInfo, 13);
        fclose($fp);
        //erases the file after retrieving information
        $fp=fopen("storedInfo.txt", "w+");
        fclose($fp);

        //retrieve the dosage info
        $dosage=$_POST['dosage'];
        $dosageTime=$_POST['dosageTime'];
        $AR=$_POST['AR'];

        //insert all the information into the table and return to the main page
        $insert=("INSERT INTO patientData (ID, medID, dosageAmount, dosageTime, startDate, endDate, AR)
        VALUES('$user', '$medID', '$dosage', '$dosageTime', '$startDate', '$endDate', '$AR')");
        $insertInto=mysqli_query($db,$insert) or die(mysqli_error($db));
        header ("location: mainPage.php");

  }

  session_destroy();
?>


<html lang = "en">
  <head>
    <title>MedMinder</title>
    <link rel="icon" type="image/ico" href="favicon.ico">
    <meta charset = "UTF-8" />
    <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">
    <style>

      body
      {
        background-attachment: fixed;
        height: 100%;
        width: 100%;
        background-image: url(http://www.pakistankakhudahafiz.com/pkkhnew/wp-content/uploads/2016/07/medicine-exports.jpg);
        overflow: auto;
      }
      p
      {
        Font-family: 'Noto Serif', serif;
        Font-size: 18px;
        color: #ffffff;
        text-shadow: 1px 0 0 #000, 0 -1px 0 #000, 0 1px 0 #000, -1px 0 0 #000;
      }
      header
      {
        position: sticky;
        width: 100%;
        text-align: center;
        font-size:50px;
        line-height: 50px;
        background-image: URL(https://cdn.shutterstock.com/shutterstock/videos/1767419/thumb/1.jpg);
        color:#ffffff;
        Font-family:'Noto Serif', serif;
        text-shadow: 1px 0 0 #000, 0 -1px 0 #000, 0 1px 0 #000, -1px 0 0 #000;
      }
      input[type=text]
      {
        width: 200px;
        height:20px;
        margin: 5px;
      }

      div.results
      {
        position: relative;
        font-family: 'Noto Serif', serif;
        font-size: 20px;
        background-color: #eff2f7;
        color: #000000;
        width: 80%;
        margin-left: auto;
        margin-right: auto;
        padding: 15px;
        outline: #000000 solid 3px;
      }
    </style>
  </head>
  <body>
    <center>
    <header>MedMinder <br>
    <input type="text" name="search" placeholder="Search Medications...">
    </header></center>
      <form action="" method="post">
        <div class="results">
        <?php

          //get username and medID
          $fp=fopen("storedInfo.txt", "r");
          $textInfo=fgets($fp, 999);
          $user=substr($textInfo, 0, 13);
          $medID=substr($textInfo, 13);
          fclose($fp);

          //get the medication that matches the id
          $query=("SELECT * FROM medications WHERE medID ='$medID'");
          //$query2=("SELECT * FROM patientData WHERE ID='$user'");
          $result=mysqli_query($db,$query) or die(mysqli_error($db));
          //$result2=mysqli_query($db,$query2) or die(mysqli_error($db));
          while($row=mysqli_fetch_assoc($result))
          {
            $clinicalName=$row['CLINNAME'];
            $brandName=$row['NAMEBRAND'];

            ?>
            <br>
            <?php

            //enter info about the size of dose, times per day, start/end dates, adverse reactions
            echo "<center>";
            echo "<b>".$brandName." (".$clinicalName.")"."</b><br><br></center>";
            echo "Size of dose: ";?>
            <input type = "text"
                  name = "dosage"
                  style="Font-family:'Noto Serif', serif; Font-size: 15px; color:#000000"
                  placeholder = "10" /> mg &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
            <?php
            echo "&nbsp;&nbsp;&nbsp;";
            echo "Times per day: ";?>
            <input type = "text"
                  name = "dosageTime"
                  style="Font-family:'Noto Serif', serif; Font-size: 15px; color:#000000"
                  placeholder = "2" /> x per day &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;

            <?php
            echo "<br>";
            echo "Start Date: ";?>
            <input type= "text"
                  name= "startDate"
                  style="Font-family: 'Noto Serif', serif; Font-size: 15px; color #000000"
                  placeholder= "01-01-2000 if unknown" /> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
            <?php
            echo "&nbsp;&nbsp;&nbsp;";
            echo "End Date: ";?>
            <input type= "text"
                  name="endDate"
                  style="Font-family: 'Noto Serif', serif; Font-size: 15px; color #000000"
                  placeholder= "01-01-2099 if unknown"/> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
            <?php
            echo "<br><br>";
            echo "Adverse Reactions"."&emsp;&emsp;"; ?>
            <input type= "text"
                  name="AR"
                  style= "Font-family: 'Noto Serif', serif; Font-size: 15px; color #000000"
                  placeholder= "Leave blank if none"/>
                <br><hr><br>
          <?php
          }
        ?>
        <br>
        <center><input type="submit" name="submit" value="Submit"></center>
      </form>
    </div>
  </body>
</html>
