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

$sql="CREATE TABLE USERS (
  IP TEXT PRIMARY KEY,
  VOTED INTEGER[]);";
$result=pg_query($db,$sql);
echo pg_last_error();

pg_close($db);
  
  
?>
</html>
