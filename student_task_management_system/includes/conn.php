<?php

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'stms_db';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_errno) {
    error_log("DATABASE CONNECTION FAILED: " . $conn->connect_error);
    die("Unable to connect to the database. Please try again later.");
}

$conn->set_charset("utf8mb4");

function fetchAll($conn, $query, $types = "", $params = [])
{
    $stmt = $conn->prepare($query);
    if ($types && $params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result();
}

function executeQuery($conn, $query, $types = "", $params = [])
{
    $stmt = $conn->prepare($query);
    if ($types && $params) {
        $stmt->bind_param($types, ...$params);
    }
    return $stmt->execute();
}
?>
