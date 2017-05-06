<!DOCTYPE HTML>
<?php
  session_start();
  $myusername= $_SESSION['myUsername'];
  define('DB_SERVER', 'localhost');
  define('DB_USERNAME', 'root');
  define('DB_PASSWORD', 'medMinder8');
  define('DB_DATABASE', 'patientmedinfo');
  $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
  if (!$db)
  {
    die("Connection Failed: " . mysqli_connect_error());
  }
  /*$fp=fopen("storedInfo.txt", "r");
  $user=fgets($fp, 999);
  fclose($fp);
  //erases the file after retrieving information
  $fp=fopen("storedInfo.txt", "w+");
  fclose($fp);*/

  //if there is no username attached, go back to login
  //prevents a non-user from accessing a user's data
  if($myusername==FALSE)
  {
    header("location: login.php");
  }
  //get today's date and format
  date_default_timezone_set('America/New_York');
  $currentDate=date("m"."-"."d"."-"."Y");
  $currentDateFormatted=date("Y"."-"."m"."-"."d");

  $patIDQuery=("SELECT * FROM patients WHERE usernam3='$myusername'");
  $patientID=mysqli_query($db, $patIDQuery);
  $row=mysqli_fetch_assoc($patientID);
  $user = $row['ID'];

  if($_SERVER["REQUEST_METHOD"]=="POST")
  {
    //record userID and the search term for searching
    $myUserID=$_POST['myUserID'];
    $searchterm=$_POST['q'];
    $fp= fopen("storedInfo.txt", "w");
    //write to file to pass on
    $output=$myUserID."\t".$searchterm;
    fwrite($fp, $output);
    fclose($fp);
    session_write_close();

    //go to search page with results
    header ("location: searchPageDup.php");
  }
  //$currentMedQuery=("SELECT * FROM patientData JOIN medications ON patientData.medID=medications.medID WHERE 'patientData.ID'='$user'");
  //$currentMedsresult = mysqli_query($db,$currentMedQuery);
  //while($row=mysqli_fetch_array($currentMedsresult))
  //{

  //}


  session_destroy();
?>

<html lang = "en">
  <head>
    <title>MedMinder</title>
    <!---<link rel="icon" type="image/ico" href="C:\Users\Cassandra\OneDrive\Documents\BIIN\Aspirin.ico"> --->
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
        width: 300px;
        -webkit-transition: width 0.4s ease-in-out;
        transition: width 0.4s ease-in-out;
        height:20px;
        margin: 5px;
      }
      input[type=text]:focus
      {
        width: 50%;
      }
      div{
        overflow: auto;
      }
      div.CurrentMeds
      {
        float: right;
        font-family: 'Noto Serif', serif;
        font-size: 20px;
        background-color: #eff2f7;
        color: #000000;
        width: 50%;
        margin: 10px;
        margin-right: 30px;
        text-align: center;
        padding: 15px;
        outline: #000000 solid 3px;
      }
      div.PastMeds
      {
        float: right;
        font-family: 'Noto Serif', serif;
        font-size: 20px;
        background-color: #eff2f7;
        color: #000000;
        width: 50%;
        margin: 10px;
        margin-right: 30px;
        text-align: center;
        padding: 15px;
        outline: #000000 solid 3px;
      }
      div.Welcome
      {
        float: left-;
        font-family: 'Noto Serif', serif;
        font-size: 18px;
        background-color: #eff2f7;
        color: #000000;
        width: 35%;
        text-align: center;
        padding: 15px;
        outline: #000000 solid 3px;
      }
      div.LastUpdated
      {
        float: left -;
        font-family: 'Noto Serif', serif;
        font-size: 18px;
        background-color: #eff2f7;
        color: #000000;
        width: 35%;
        margin-top: 20px;
        padding: 15px;
        text-align: center;
        outline: #000000 solid 3px;
      }
      div.InteractionFormatting
      {
        float: left -;
        font-family: 'Noto Serif', serif;
        font-size: 18px;
        background-color: #eff2f7;
        color: #000000;
        width: 40%;
        margin-top: 20px;
        padding: 15px;
        text-align: left;
        outline: #000000 solid 3px;
      }


      /*textareaWelcome
      {
        position: absolute;
        left: 20px;
        top: 130px;
        font-family: 'Noto Serif', serif;
        font-size: 18px;
        background-color: #eff2f7;
        color: #000000;
        margin: 5px;
        padding: 15px;
        text-align: center;
        outline: #000000 solid 3px;
      }*/
    /*  textareaLastUpdate
      {
        position: absolute;
        left: 20px;
        top: 300px;
        font-family: 'Noto Serif', serif;
        font-size: 18px;
        background-color: #eff2f7;
        color: #000000;
        margin: 5px;
        padding: 15px;
        text-align: center;
        outline: #000000 solid 3px;
      }*/

      /*textareaYourMedications
      {
        position: absolute;
        right: 20px;
        top: 130px;
        font-family: 'Noto Serif', serif;
        font-size: 20px;
        background-color: #eff2f7;
        color: #000000;
        width: 50%;
        margin: 5px;
        margin-left: 20px;
        text-align: center;
        outline: #000000 solid 3px;
      } */
      /*textareaPastMedications
      {
        position: absolute;
        right: 20px;
        top: calc(textareaYourMedications + 100px);
        font-family: 'Noto Serif', serif;
        font-size: 20px;
        background-color: #eff2f7;
        color: #000000;
        width: 50%;
        margin: 5px;
        margin-left: 20px;
        text-align: center;
        outline: #000000 solid 3px;
      }*/
      </style>
    </head>
  <body>
    <center>
    <header>MedMinder <br>
      <form action="" method="post">
        <input type="text" name="q" placeholder="Search Medications..."/>
        <input type="submit" name="searchButton" value="Enter"/>
        <input type="hidden" name="myUserID" value="<?php echo $user;?>"/>
      </form>
    </header>
    </center>
    <div class= "CurrentMeds"> Current Medications </div> <br>
    <div class="CurrentMeds">
      <?php
      //get a list of medications the patient is currently on
        $clinNameQC=("SELECT * FROM medications RIGHT JOIN patientData ON patientData.medID=medications.medID WHERE patientData.ID='$user'AND patientData.endDate >'$currentDateFormatted' AND patientData.startDate<='$currentDateFormatted'");
        $clinNameC=mysqli_query($db,$clinNameQC);
        while($rowClinC=mysqli_fetch_assoc($clinNameC))
        {
          //get the names of the drug
          $clinicalNameC=$rowClinC['CLINNAME'];
          $brandNameC=$rowClinC['NAMEBRAND'];
          //add url for OpenFDA query
          $url=file_get_contents("https://api.fda.gov/drug/label.json?search=drug_interactions:".(str_replace(" ", "-",$clinicalNameC)));
          //(str_replace("-"," ",$row[website])
          //get the results of the query
          $result=json_decode($url);
          //print_r($result->results[0]->drug_interactions);
          //var_dump($result);

          echo "<b>";
          //display names
          echo $brandNameC." (".$clinicalNameC.")"."<br>"."</b>";
          echo "<div align=left>";

          //display dosage & dosage amount
          echo "Dosage: ". $dosageAMTC=$rowClinC['dosageAmount']."mg";
          echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

          //display times per day
          echo "Times per day: "."&nbsp;&nbsp;".$dosageTimeC=$rowClinC['dosageTime']."x per day";
          echo "<br>";

          //display start and end dates
          echo "Start Date: ".$startDateC=$rowClinC['startDate']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          echo "End Date: ".$endDateC=$rowClinC['endDate']."<br>";

          //display any adverse reactions
          echo "Adverse reactions: ".$ARC=$rowClinC['AR']."<br>";

          //open a new text document to append interactions
          $fi=fopen("interactions.txt", "a");

          //make the array a string
          $interactions_list=implode(".", $result->results[0]->drug_interactions);

          //write to document
          fwrite($fi, $clinicalNameC);
          fwrite($fi, ":");
          fwrite($fi, "\r\n");
          fwrite($fi, $interactions_list);
          fwrite($fi, "\r\n");
          fwrite($fi, "\r\n");
          fclose($fi);
          ?></div><hr>
          <?php
        }
      ?></div>
    <div class= "PastMeds"> Past Medications </div> <br>
    <div class= "PastMeds"> <?php
    //select medications from the past
      $clinNameQP=("SELECT * FROM medications RIGHT JOIN patientData ON patientData.medID=medications.medID WHERE patientData.ID='$user'AND (patientData.endDate <='$currentDateFormatted') AND (patientData.startDate <='$currentDateFormatted')");
      $clinNameP=mysqli_query($db,$clinNameQP);
      while($rowClinP=mysqli_fetch_assoc($clinNameP))
      {
        ?><?php
        $clinicalNameP=$rowClinP['CLINNAME'];
        $brandNameP=$rowClinP['NAMEBRAND'];
        echo "<b>";
        echo $brandNameP." (".$clinicalNameP.")"."<br>"."</b>";
        echo "<div align=left>";
        echo "Dosage: ". $dosageAmtTP=$rowClinP['dosageAmount']."mg";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "Times per day: "."&nbsp;&nbsp;".$dosageTimeP=$rowClinP['dosageTime']."x per day";
        echo "<br>";
        echo "Start Date: ".$startDateP=$rowClinP['startDate']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "End Date: ".$endDateP=$rowClinP['endDate'];?></div><hr><?php
      }
    ?></div>
    <div class= "Welcome">Welcome back, <?php echo $myusername ?> </div>
    <div class= "LastUpdated"> This website was last updated on <?php echo "04-12-17" ?><br> Today's date is <?php echo date("m"."-". "j"."-". "Y"); ?></div>
    <div class= "InteractionFormatting">
    <?php
      //$fi=fopen("interactions.txt", "r");
      //$interactions=fgets($fi, 999);
      //fclose($fi);
      //get the interactions from the text file and display them
      $interactions=file_get_contents("interactions.txt");
      echo $interactions;
    ?></div>
  </body>
  <?php
  //delete the the information in the file
  $fi=fopen("interactions.txt", "w+");
  fclose($fi) ;?>
</html>
