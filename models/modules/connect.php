<?php
// Create connection
function connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME)
{
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}