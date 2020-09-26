<?php
    include('config.php');
    $conn = new mysqli($servername, $username, $password, $dbname);
    function check_connection(){
        global $conn;
        if ($conn != null) return;
        $conn = new mysqli($servername, $username, $password, $dbname);  
    }
    function init_database(){
        check_connection();
        global $conn;
        // create table
        $sql = "CREATE TABLE graph (
            idFrom 	int(11) NOT NULL,
            idTo 	int(11) NOT NULL,
            dist 	int(11) NOT NULL,
            PRIMARY KEY (idFrom, idTo)
            )";

        if ($conn->query($sql) === TRUE) {
            echo "Table created successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        }

        //fill database
        for ($from = 1; $from <= 100; $from++) 
            for ($to = 1; $to <= 100; $to++){
                if($from == $to) continue;
                $sql = "INSERT INTO graph(idFrom, idTo, dist)"."\n"."
                    VALUES(".$from.",".$to.",".random_int(50, 5000).")";
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                    } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                    }
        }
    }
    function update_database($from, $to, $new_dist){
        check_connection();
        global $conn;
        if($from == $to) return;
        $sql = "UPDATE graph SET dist=".$new_dist." WHERE idFrom=".$from." and idTo=".$to;
        assert($conn->query($sql) === TRUE);
    }
    function multi_update_database($graph){
        check_connection();
        for ($from = 1; $from <= 100; $from++) 
            for ($to = 1; $to <= 100; $to++){
                update_database($from, $to, $graph[$from][$to]);
            }
    }
    function query_database($from, $to, &$ans){
        check_connection();
        global $conn;
        $sql = "SELECT idFrom, idTo, dist FROM graph
                WHERE idFrom=".$from." and idTo=".$to;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // output data of each row
            $ans = $row["dist"];
          } else {
            $ans = 0;
          }
    }
    function load_graph(&$graph){
        check_connection();
        global $conn;
        for ($from = 1; $from <= 100; $from++) 
          for ($to = 1; $to <= 100; $to++){
              if($from == $to){
                $graph[$from][$to] = 0;
                continue;
              }
              query_database($from, $to, $graph[$from][$to]);
          }
    }

?>