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
$query="INSERT INTO MAIN VALUES(" . $id . "," . $name . ")";
$result = pg_query($db, $query);
if ($result) {
  echo 'id added';
} else {
  echo'fuck1';
};
 pg_close($db);
  
  
?>
</html>
