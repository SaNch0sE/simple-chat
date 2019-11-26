<?php
// Config
require_once 'config.php';
// Extensions/modules
require 'models/modules/connect.php';
require 'models/modules/sql_lib.php';
require 'models/modules/validateData.php';
// Models
require 'models/admin_log_in.php';
require 'models/adminPanel.php';
require 'models/log_in.php';
require 'models/messenger.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$raw_data = serialize(json_decode(file_get_contents('php://input')));
$granted = validateData($data);
// Find action
$action = $data['action'];
$conn = connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Do action
if ($granted) {
    if ($action === 'sendMessage') {
        write($data);
    } elseif ($action === 'getMessages') {
        response();
    } elseif ($action === 'reg') {
        reg($conn, $data);
    } elseif ($action === 'showUsers') {
        showUsers();
    } elseif ($action === 'createdb') {
        createdb($conn);
    } elseif ($action === 'adminVal') {
        adminVal($conn, $data);
    } else {
        echo "Error: Action not found in '" . $raw_data . "'";
    }
} else {
    echo "Error: Validation data failure in '" . $raw_data . "'";
}
$conn->close();