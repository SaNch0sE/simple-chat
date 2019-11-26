<?php
function validate($log, $pwd) {
    $result = do_sql_work("select", "*", "users", function ($data) use ($pwd, $log) {
        if($data !== "Error") {
            if ($data->num_rows > 0) {
                // output data of each row
                while ($row = $data->fetch_assoc()) {
                    if ($row["user"] == $log && $row["password"] == $pwd) {
                        return "correct";
                    }
                }
            } else {
                return "No users";
            }
        }
    });
    return $result;
}
//
// Registration or login
//
function reg($conn, $data) {
    $login = $data['data']['login'];
    $pwd = $data['data']['pwd'];
    //echo 'Your login is ' . $login . " and password is " . $pwd;
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $dbdata = array();
    $exist = "doesnt";
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if ($row["user"] === $login) {
                $exist = "exist";
            }
        }
    }
    if ($exist === "exist") {
        if (validate($login, $pwd) === "correct") {
            echo '{"access": true, "login":"' . $login . '"}';
        } else {
            echo '{"access": false, "login":"\nEnter a valid data"}';
            return;
        }
    } else {
        $sql = "INSERT INTO users (user, password) VALUES ('" . $login . "', '". $pwd ."')";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        } else {
            echo '{"access": true, "login":"' . $login . '"}';
        }
    }
}