<html>

<h1>Add Items!</h1>

<?php
# This function reads your DATABASE_URL config var and returns a connection
# string suitable for pg_connect. Put this in your app.
function pg_connection_string_from_database_url() {
  extract(parse_url($_ENV["DATABASE_URL"]));
  return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
}
# Here we establish the connection. Yes, that's all.
$db = pg_connect(pg_connection_string_from_database_url());
# Now let's use the connection for something silly just to prove it works:
$name=htmlspecialchars($_GET["name"]);
$id=htmlspecialchars($_GET["id"]);
if (!$id or !$name) {
  echo 'Enter a name or id';
} else {
  $query="INSERT INTO MAIN VALUES (" . $id . ",'" . $name . "');";
  #$query="ALTER TABLE MAIN
   # ALTER COLUMN id TEXT;";
  $result = pg_query($db, $query);
  echo $result;
     $sql ="
        CREATE TABLE num" . $id . "(
        OPTION           TEXT    PRIMARY KEY,
        VOTES            INT     NOT NULL);";
  $ret = pg_query($db, $sql);
  echo $ret;
}
if (!$result) {
  echo pg_last_error();
  echo'fuck4';
}
if (!$ret) {
  echo pg_last_error();
}
 pg_close($db);
  
  
?>
</html>
