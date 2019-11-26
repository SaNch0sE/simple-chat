<?php
function write($data) {
    $nick = $data['data']['nick'];
    $msg = $data['data']['msg'];
    if ($nick != "") {
        do_sql_work("insert", array("nick"=>$nick, "message"=>$msg), "messages", function ($d){
            if ($d === "No errors"){
                echo json_encode($d);
            } else {
                echo '["Write error"]';
            }
        });
    }
}
//
// Send all messages to client
//
function response() {
    do_sql_work("select", "*", "messages", function ($result){
        $dbdata = array();
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $dbdata[]=$row;
            }
        } else {
            $dbdata = "No messages";
        }
        echo json_encode($dbdata);
    });
}