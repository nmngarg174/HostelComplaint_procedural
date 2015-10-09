<?php

if (!isset($_POST['email'])) {
    header("location:login.php");
}
include_once 'con_procedural.php';
$email = $_POST['email'];
$pass = $_POST['password'];
$salt = "thispasswordcannotbehacked";
$pass = hash('sha256', $salt . $pass);
$query = 'select * from login where email="' . $email . '" and pass="' . $pass . '"';
$q = mysqli_query($con, $query) or die("Error in execution");
if (!$q)
    echo "error in query " . mysqli_error($con);
$row = mysqli_fetch_array($q);
if ($row['email'] == '') {
    echo 0;
} else {

    session_start();
    $query = 'select fname, user_type, regno, email,roomno from registration where registration.email="' . $row['email'] . '"';
    $q = mysqli_query($con, $query);
    if (!$q)
        echo "error in 2nd query " . mysqli_error($con);
    $_SESSION['id'] = session_id();
    $row = mysqli_fetch_array($q);
    $_SESSION['email'] = $row['email'];
    $_SESSION['name'] = $row['fname'];
    $_SESSION['user_type'] = $row['user_type'];
    $_SESSION['roll'] = $row['regno'];
    if ($row['user_type'] == 'student')
        echo 'complaint.php';
    else if ($row['user_type'] == 'caretaker')
        echo 'caretaker.php';
    else if ($row['user_type'] == 'warden')
        echo 'warden.php';
}
?>