<html>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<center>
  
<?php
function pg_connection_string_from_database_url() {
  extract(parse_url($_ENV["DATABASE_URL"]));
  return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
}

$db = pg_connect(pg_connection_string_from_database_url());
$toPrint="";
  
function vote ($tableNo, $option) {
  global $db, $toPrint;
  # user ip checking
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
      $ip = $_SERVER['REMOTE_ADDR'];
  }
  $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$ip"));
  $country = $geo["geoplugin_countryName"];
  $city = $geo["geoplugin_city"];


  # vote adding
  if ($city=='Pittsburgh') {  
    $toPrint.= 'in pittsburgh<br>';
    $tableNo=htmlspecialchars($_GET["id"]);
    $option=htmlspecialchars($_GET["option"]);
    $voted="";
    $query="INSERT INTO USERS VALUES ( '".$ip."', '".$voted."');";
    $result=pg_query($db,$query);
    if (pg_last_error()) {
      $toPrint.= 'User already in table<br>';
      $query="SELECT VOTED FROM USERS WHERE IP='".$ip."'";
      $result=pg_query($db,$query);
      $arr=pg_fetch_all($result);
      $voted=$arr[0]['voted'];
    }
    if (in_array($tableNo,explode(" ",$voted))) {
      $toPrint.= 'You already voted! fuck you!<br>';
    } else {
      $sql = "SELECT VOTES FROM num".$tableNo." WHERE OPTION='".$option."'";
      $result = pg_query($sql);
      $value = pg_fetch_all($result);
      $votes=$value[0]['votes'];
      ++$votes;
      echo pg_last_error();
      $sql="UPDATE num".$tableNo." SET VOTES=".$votes." WHERE OPTION='".$option."'";
      $result=pg_query($db,$sql);
      echo pg_last_error();

      $voted.=" ".$tableNo;
      $query="UPDATE USERS SET VOTED='".$voted."' WHERE IP='".$ip."'";
      $result=pg_query($db,$query);
      echo pg_last_error();
    }
    echo pg_last_error();
  } else {
    $toPrint.= "fuck you. you ain't in pittsburgh, bitch<br>";
  }

}
$id = htmlspecialchars($_GET["id"]);
$choice = htmlspecialchars($_GET["option"]);
  if ($choice) {
    vote($id, $choice);
  }

    $sql="SELECT name FROM MAIN WHERE id=".$id;
    $result=pg_query($db,$sql);
    $arr = pg_fetch_all($result);
    print_r("<center><h1>".$arr[0]['name']."</h1></center>");
  
    $result = pg_query($db, "SELECT * FROM num".$id . " ORDER BY VOTES DESC;");
   while ($row = pg_fetch_row($result)) {
    $counter = 0;
    foreach($row as $option) {
      if($counter % 2 ==0){#OPTION
          $fixedOption=htmlspecialchars($option);
//           echo "<a href='/view.php?id=".$id."&option=".$fixedOption."'>Vote</a>";
          echo '<h2>';
          echo "<a href='/view.php?id=".$id."&option=".$fixedOption."'>".$option; 
          echo '';
      }else{#VOTES
          echo '    -    ';
          echo $option; 
          echo '</a></h2></br>';


      }
           $counter = $counter+1;

    }
}
  echo pg_last_error();
  echo $toPrint;
  pg_close($db);
?>
  </center>
</html>
