<center><h1>Users:</h1><center>

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
    
  
    $result1 = pg_query($db, "SELECT * FROM USERS");

if (pg_num_rows($result1)>0) {

        while($userINPUTArray = pg_fetch_array($result1))
        {
        print_r($userINPUTArray);
        }
    } else {

        echo ("Failed");
    }
