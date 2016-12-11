<html>

<h1>Add Options!</h1>

<?php
$option = $_POST['option'];
$id=$_POST['id'];

if ($id and $option) {
  # This function reads your DATABASE_URL config var and returns a connection
  # string suitable for pg_connect. Put this in your app.
  function pg_connection_string_from_database_url() {
    extract(parse_url($_ENV["DATABASE_URL"]));
    return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
  }
  # Here we establish the connection. Yes, that's all.
  $db = pg_connect(pg_connection_string_from_database_url());

  if (!$id or !$option) {
    echo "Enter an option and id";
  } else {
    $query="INSERT INTO num".$id. " VALUES ( '".$option."', 0);";
    $result=pg_query($db,$query);
    echo pg_last_error();
  }

  pg_close($db);
}
if(isset($_POST))
{?>

  <form method="POST" action="addOption.php">
  ID <input type="text" name="id"></input><br/>
  Option <input type="text" name="option"></input><br/>
  <input type="submit" name="submit" value="Add Option"></input>
  </form>

<?}
if ($id and $option) {
  echo "<h2>".$option." Added</h2>";
}
  
  
?>
</html>
