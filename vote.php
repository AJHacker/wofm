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
$ip=getenv('REMOTE_ADDR');
$geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
$country = $geo["geoplugin_countryName"];
$city = $geo["geoplugin_city"];
echo $ip;
echo $city;
  
# vote adding
$tableNo=htmlspecialchars($_GET["id"]);
$option=htmlspecialchars($_GET["option"]);
$sql = "SELECT VOTES FROM num".$tableNo." WHERE OPTION='".$option."'";
$result = pg_query($sql);
$value = pg_fetch_all($result);
$votes=$value[0]['votes'];
++$votes;
echo pg_last_error();
echo $votes;
$sql="UPDATE num".$tableNo." SET VOTES=".$votes." WHERE OPTION='".$option."'";
$result=pg_query($db,$sql);
echo pg_last_error();

pg_close($db);
  
  
?>
</html>
