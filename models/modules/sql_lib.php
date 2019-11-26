<?php
	function do_sql_work($action, $object, $table, $callback) {
        $response = array("error"=>"Error: SQL action not found");
		$connect = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        // Check connection
        if (!$connect) {
            die("Connection failed: " . $connect->connect_error);
        }
        else {
            if ($action === "insert") {$response = insert($object, $table, $connect);}
            if ($action === "select") {$response = select($object, $table, $connect);}
            mysqli_close($connect);
        }
        return $callback($response);
	}
	function insert($obj, $table, $connect) {
	    $table = $connect->real_escape_string($table);
	    $sqlKeys = "";
	    $values = "";
		foreach ($obj as $key => $value) {
		    if ($sqlKeys !== "" && $values !== ""){
                $sqlKeys = $sqlKeys . "," . $connect->real_escape_string($key);
                $values = $values . '","' . $connect->real_escape_string($value);
            } else {
                $sqlKeys = $connect->real_escape_string($key);
                $values = '"' . $connect->real_escape_string($value);
            }
		}
		$values = $values . '"';
        $sql = "INSERT INTO $table ($sqlKeys) VALUES ($values)";
        if ($connect->query($sql)){
            $response = "No errors";
        } else {
            $response = "Error: " . $sql . "<br>" . $connect->error;
        }
		return $response;
	}
	function select($obj, $table, $connect ) {
	    $table = $connect->real_escape_string($table);
	    if (is_array($obj)) {
	        $obj = implode("','", $connect->real_escape_string($obj));
            $sql = 'SELECT ' . $obj . ' FROM ' . $table;
            $response = $connect->query($sql);
            return $response;
	    } else if($obj === "*") {
            $sql = 'SELECT ' . $obj . ' FROM ' . $table;
            $response = $connect->query($sql);
            return $response;
        } else {
             return "Error";
        }
	}