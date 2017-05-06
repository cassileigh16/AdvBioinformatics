<!DOCTYPE HTML>
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


  //go to the final page
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    header ("location: results.php");
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
    <!--- Print each result as different box, create click box on left and info about dosing--->
      <form action="" method="post">
        <div class="results">
        <?php
          //get the userid and serach term that was stored from the main page
          $fp=fopen("storedInfo.txt", "r");
          $terms=fgets($fp, 999);
          $userID=substr($terms, 0, 13);
          $searchterm= substr($terms, 14);
          fclose($fp);
          //erases the file after retrieving information
          $fp=fopen("storedInfo.txt", "w+");
          fclose($fp);
          //rewrites the userid
          $fp=fopen("storedInfo.txt", "w");
          fwrite($fp, $userID);
          fclose($fp);

          $query=("SELECT * FROM medications WHERE (NAMEBRAND LIKE '$searchterm') OR (CLINNAME LIKE '$searchterm')");
          $result=mysqli_query($db,$query) or die(mysqli_error($db));
          while($row=mysqli_fetch_assoc($result))
          {
            //get the names and IDs for the medications
            $clinicalName=$row['CLINNAME'];
            $brandName=$row['NAMEBRAND'];
            $identifier=$row['medID'];
            ?>
            <br>
            <!--- put in radio buttons that are identified by medID--->
            <input type="radio" name="check_list" value=<?php echo $identifier;?> >&emsp;&emsp;&emsp;<b>
            <?php
            echo "$brandName". " (".$clinicalName.")"; ?> </b><br>
          <?php
        }

        if (isset($_POST['check_list']))
        {
          //write to txt file with id
          $identifier=$_POST['check_list']; // Displays value of checked checkbox.
          $fp=fopen("storedInfo.txt", "a");
          $textInfo="\t".$identifier;
          fwrite($fp, $textInfo);
          fclose($fp);
        }
        ?>
        <br>
        <center><input type="submit" name="submit" value="Submit"></center>
      </form>
    </div>
  </body>
</html>
