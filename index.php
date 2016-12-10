<html>

<h1>Welcome!</h1>

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
    
  
   echo '<h1>TABLES:</h1>';
    $result1 = pg_query($db, "SELECT relname FROM pg_stat_user_tables WHERE schemaname='public'");
    print "<pre>\n";
    if (!pg_num_rows($result1)) {
      print("Your connection is working, but your database is empty.\nFret not. This is expected for new apps.\n");
    } else {
     print "Tables in your database:\n";
     while ($row = pg_fetch_row($result1)) { print("- $row[0]\n"); }
    }

  
  
   echo '<h1>MAIN:</h1>';

   $result = pg_query($db, "SELECT ID, NAME FROM MAIN ORDER BY ID DESC LIMIT 1000");
   $arr = pg_fetch_all($result);
   print_r(array_values($arr));
   pg_close($db);
?>
  
</html>
