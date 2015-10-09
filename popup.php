<?php

include_once "./con_procedural.php";
session_start();
if (!isset($_SESSION['id'])) {
    header('location:index.php');
}
require_once 'functions.php';
$_SESSION['compid'] = $_POST['send'];
$sql = "SELECT * FROM complaints where comp_id = '" . $_POST['send'] . "' order by comp_date desc";
$retval = mysqli_query($con, $sql) or die('Could not get data: ' . mysqli_error($con));
$row = mysqli_fetch_array($retval);
echo $row['name'] . "," . $row['comp_id'] . "," . $row['category'] . "," . $row['roomno'] . "," . format_date($row['comp_date']) . "(" . date("H:i:s", strtotime($row['comp_date'])) . ")" . "," . $row['status'] . "," . $row['details'];

$sql = "SELECT * FROM remarks where comp_id = '" . $_POST['send'] . "' order by time desc";
$retval = mysqli_query($con, $sql) or die('Could not get data: ' . mysqli_error($con));
while ($row = mysqli_fetch_array($retval))
    echo "," . $row['user_type'] . "," . format_date($row['time']) . "(" . date("H:i:s", strtotime($row['time'])) . ")" . "," . $row['remark'];
?>