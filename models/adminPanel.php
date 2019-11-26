<?php
function createdb($conn){
    $data = '[';
    $sql = "CREATE TABLE messages (id int NOT NULL UNIQUE AUTO_INCREMENT, date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, nick varchar(255), message varchar(255));";
    if($conn->query($sql) === TRUE) {
        $data = $data.'{"data": "Messages: Created"}';
    } else {
        $data = $data.'{"data": "Error: ' . $conn->error . '"}';
    }
    $sql = "CREATE TABLE users (id int NOT NULL UNIQUE AUTO_INCREMENT, user varchar(30), password varchar(255));";
    if($conn->query($sql) === TRUE) {
        $data = $data . ', {"data": "Messages: Created"}';
    } else {
        $data = $data . ', {"data": "Error: ' . $conn->error . '"}';
    }
    $sql = "CREATE TABLE admins (id int NOT NULL UNIQUE AUTO_INCREMENT, login varchar(30) UNIQUE, password varchar(255) UNIQUE);";
    if($conn->query($sql) === TRUE) {
        $data = $data . ', {"data": "Admins: Created"}';
        $sql = "INSERT INTO admins (login, password) VALUES ('admin', 'nimda')";
        if($conn->query($sql) === TRUE) {
            $data = $data . ', {"data": "admin: Created"}';
        } else {
            $data = $data . ', {"data": "Error: ' . $conn->error . '"}';
        }
    } else {
        $data = $data . ', {"data": "Error: ' . $conn->error . '"}';
        $sql = "INSERT INTO admins (login, password) VALUES ('admin', 'nimda')";
        if($conn->query($sql) === TRUE) {
            $data = $data . ', {"data": "admin: Created"}';
        } else {
            $data = $data . ', {"data": "Error: ' . $conn->error . '"}';
        }
    }
    echo $data . ']';
}
function showUsers() {
    $result = do_sql_work("select", "*", "users", function ($data) {
        if($data !== "Error") {
            $dbdata = array();
            if ($data->num_rows > 0) {
                // output data of each row
                while ($row = $data->fetch_assoc()) {
                    $dbdata[] = $row;
                }
            } else {
                $dbdata = "No users";
            }
            return json_encode($dbdata);
        } else {
            return json_encode('{"resp":"Error"}');
        }
    });
    echo $result;
}