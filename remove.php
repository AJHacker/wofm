<html>

<h1>Remove Questions or Options</h1>
  <h2>Enter a Question ID to remove a question</h2>
  <h2>Enter a Question ID and Option to remove a specific option</h2>

<?php
$option = $_POST['option'];
$id=$_POST['id'];

if ($id) {
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
  } elseif ($option) {
    $sql="DELETE FROM num".$id." WHERE OPTION='".$option."'";
    $result=pg_query($db,$sql);
  } else {
    $sql="DROP TABLE num".$id.";
    $result=pg_query($db,$sql);
  }
  pg_close($db);
} else {
  if(isset($_POST)) {?>

    <form method="POST" action="remove.php">
    ID <input type="text" name="id"></input><br/>
    Option <input type="text" name="option"></input><br/>
    <input type="submit" name="submit" value="Add Option"></input>
    </form>

  <?php}
}

?>
</html>
