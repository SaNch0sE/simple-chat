<?php
function adminVal($conn, $data) {
    $login = $data['data']['login'];
    $pwd = $data['data']['password'];
    $sql = "SELECT * FROM admins";
    $result = $conn->query($sql);
    $dbdata = '{"resp": "error"}';
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            if ($row["login"] === $login && $row["password"] === $pwd) {
                $dbdata = '{"resp": true}';
                break;
            } else {
                $dbdata = '{"resp": "' . $login . ', ' . $pwd . '"}';
            }
        }
    }
    echo $dbdata;
}