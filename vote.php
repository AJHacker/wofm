<html>
<?php
# This function reads your DATABASE_URL config var and returns a connection
# string suitable for pg_connect. Put this in your app.
function pg_connection_string_from_database_url() {
  extract(parse_url($_ENV["DATABASE_URL"]));
  return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
}
# Here we establish the connection. Yes, that's all.
$db = pg_connect(pg_connection_string_from_database_url());

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
  echo 'in pittsburgh<br>';
  $tableNo=htmlspecialchars($_GET["id"]);
  $option=htmlspecialchars($_GET["option"]);
  try {
    $voted="";
    $query="INSERT INTO USERS VALUES ( '".$ip."', '".$voted."');";
    $result=pg_query($db,$query);
  } catch (Exception $e) {
    echo 'user already in table<br>';
    $query="SELECT VOTED FROM USERS WHERE IP='".$ip."'";
    $result=pg_query($db,$query);
    $arr=pg_fetch_all($result);
    $voted=$arr[0]['voted'];

    echo pg_last_error();
  }
  if (in_array($tableNo,explode(" ",$voted))) {
    echo 'you already voted! fuck you!';
  } else {
    $sql = "SELECT VOTES FROM num".$tableNo." WHERE OPTION='".$option."'";
    $result = pg_query($sql);
    $value = pg_fetch_all($result);
    $votes=$value[0]['votes'];
    ++$votes;
    echo pg_last_error();
    echo $votes;
    $sql="UPDATE num".$tableNo." SET VOTES=".$votes." WHERE OPTION='".$option."'";
    $result=pg_query($db,$sql);
    
    echo $voted;
    $voted.=" ".$option
    $query="UPDATE USERS SET VOTED='".$voted."' WHERE IP='".$ip."'";
    $result=pg_query($db,$query);
    echo pg_last_error();
  }
  echo pg_last_error();
} else {
  echo "fuck you. you ain't in pittsburgh, bitch";
}
pg_close($db);
  
  
?>
</html>
