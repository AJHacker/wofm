<html>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
  
<center><h1>CMU Questions</h1><center>
<?php
$category = $_GET['category'];
if($category)
{
                      # This function reads your DATABASE_URL config var and returns a connection
                      # string suitable for pg_connect. Put this in your app.
                      function pg_connection_string_from_database_url() {
                      extract(parse_url($_ENV["DATABASE_URL"]));
                      return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
                      }
                      # Here we establish the connection. Yes, that's all.
                      $db = pg_connect(pg_connection_string_from_database_url());
                      # Now let's use the connection for something silly just to prove it works:


                        $result1 = pg_query($db, "SELECT relname FROM pg_stat_user_tables WHERE schemaname='public' ORDER BY RELNAME");
                        print "<pre>\n";
                        if (!pg_num_rows($result1)) {
                          print("Your connection is working, but your database is empty.\nFret not. This is expected for new apps.\n");
                        } else {
                         while ($row = pg_fetch_row($result1)) { 
                           if (!($row[0] == "main" or $row[0] == "users" or substr($row[0],-2) != $category)){
                             $tableNo=substr($row[0],3);
                             $sql="SELECT name FROM MAIN WHERE id=".$tableNo." ORDER BY ID";
                             $result = pg_query($db, $sql);
                             $arr = pg_fetch_all($result);
                             print_r("<center><h2><a href='/view.php?id=".$tableNo."'>".$arr[0]['name']."</a></h2></center>");
                           }
                         }
                        }

                      //    echo '<h1>MAIN:</h1>';

                      //    $result = pg_query($db, "SELECT ID, NAME FROM MAIN ORDER BY ID DESC LIMIT 1000");
                      //    $arr = pg_fetch_all($result);
                      //    print_r(array_values($arr));
                       pg_close($db);
}
else
{
    if(isset($_POST))
    {?>
             <h2>
               <a href = 'index.php?category=00'>Food</a><br>
               <a href = 'index.php?category=01'>Places</a><br>
               <a href = 'index.php?category=02'>People</a><br>
             </h2> 
            
    <?}
}
?>

  
</html>
