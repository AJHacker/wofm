<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<h1>Add Items!</h1>

<?php
  
$name = $_POST['question'];
$id = $_POST['id'];
$group = $_POST['group'];
if ($name and $id and $group) {
  # This function reads your DATABASE_URL config var and returns a connection
  # string suitable for pg_connect. Put this in your app.
  function pg_connection_string_from_database_url() {
    extract(parse_url($_ENV["DATABASE_URL"]));
    return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
  }
  # Here we establish the connection. Yes, that's all.
  $db = pg_connect(pg_connection_string_from_database_url());
  # Now let's use the connection for something silly just to prove it works:
  $query="INSERT INTO MAIN VALUES (" . $id . $group . ",'" . $name . "');";
  #$query="ALTER TABLE MAIN
   # ALTER COLUMN id TEXT;";
  $result = pg_query($db, $query);
     $sql ="
        CREATE TABLE num" . $id . $group . "(
        OPTION           TEXT    PRIMARY KEY,
        VOTES            INT     NOT NULL);";
  $ret = pg_query($db, $sql);
  if (!$result) {
    echo pg_last_error();
  }
  if (!$ret) {
    echo pg_last_error();
  }
   pg_close($db);
}
if(isset($_POST))
{?>

  <form method="POST" action="add.php">
  Question <input type="text" name="question"></input><br/>
  ID <input type="text" name="id"></input><br/>
  Group <input type="text" name="group"></input><br/>
  <input type="submit" name="submit" value="Add"></input>
  </form>

  <p>Group Numbers</p>
  <ul>
    <li>00 - Food</li>
    <li>01 - Places</li>
    <li>02 - People</li>
  </ul>
<?}
if ($id) {
  echo "<h2>Question Added</h2>";
}
  
?>
</html>
