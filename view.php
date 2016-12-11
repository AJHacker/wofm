<html>


<?php
function pg_connection_string_from_database_url() {
  extract(parse_url($_ENV["DATABASE_URL"]));
  return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
}

    $db = pg_connect(pg_connection_string_from_database_url());
    $id = htmlspecialchars($_GET["id"]);
    $sql="SELECT name FROM MAIN WHERE id=".$id;
    $result=pg_query($db,$sql);
    $arr = pg_fetch_all($result);
    print_r("<center><h1>".$arr[0]['name']."</h1></center>");
  
    $result = pg_query($db, "SELECT * FROM num".$id . " ORDER BY VOTES DESC;");
    print "<pre>\n";
   while ($row = pg_fetch_row($result)) {
    $counter = 0;
    foreach($row as $option) {
      if($counter % 2 ==0){#OPTION
          $fixedOption=htmlspecialchars($option);
          echo "<a href=/vote.php?id=".$id."&option=".$fixedOption.">Vote</a>";
          echo '<h1>';
          echo $option; 
          echo '';
      }else{#VOTES
          echo '    -    ';
          echo $option; 
          echo '</h1></br>';


      }
           $counter = $counter+1;

       # echo '<h1>' . $field[0] . '   -    ' . $field[1] . '</h1></br>';
    }
}
//     print $result1;
//     if (!pg_num_rows($result1)) {
//       print("Your connection is working, but your database is empty.\nFret not. This is expected for new apps.\n");
//     } else {
//      while ($row = pg_fetch_row($result1)) { 
//            print_r("<center><h2>".$row[0]['option']." - ".$row[0]['votes']."</h2></center>");
//        }
//      }
    

  
  
//    echo '<h1>MAIN:</h1>';

//    $result = pg_query($db, "SELECT ID, NAME FROM MAIN ORDER BY ID DESC LIMIT 1000");
//    $arr = pg_fetch_all($result);
//    print_r(array_values($arr));
   pg_close($db);
?>
  
</html>
