if (pg_num_rows($userINPUTresult)>0) {

        while($userINPUTArray = pg_fetch_array($userINPUTresult))
        {
        print_r($userINPUTArray);

        echo "INPUT CHAIN RULES LOADED \n";
        }
    } else {

        echo ("NO INPUT CHAIN RULES \n");
    }
