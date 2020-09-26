<?php
include('database_utils.php');
include('graph_utils.php');

function update($from, $to, $new_dist){
    check_connection();
    $graph = array();
    load_graph($graph);
    $graph[$from][$to] = $new_dist;
    FloydWarshall($graph, 100);
    multi_update_database($graph);
}
function query($from, $to, &$ans){
    check_connection();
    query_database($from, $to,$ans);
}

// close connection
//$conn->close();


?>