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
#$query="INSERT INTO MAIN ( id, name) VALUES (" . $id . "," . $name . ")";
$query="ALTER TABLE MAIN
  ALTER COLUMN id string";
$result = pg_query($db, $query);
echo $result;
if (!$result) {
  echo pg_last_error();
  echo'fuck4';
} else {
  echo 'id added';
}
 pg_close($db);
  
  
?>
</html>
