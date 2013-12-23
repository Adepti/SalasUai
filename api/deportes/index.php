<?php

// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// The JSON standard MIME header.
header('Content-type: application/json');
// params
$key = $_GET['key'];
$usr = $_GET['usr'];
$pwd = $_GET['pwd'];
$action = $_GET['action'];
$event = $_GET['event'];
// Send the data.
echo json_encode($data);

?>