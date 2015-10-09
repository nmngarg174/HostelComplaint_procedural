<head>
    <link rel="stylesheet" href="css/style.css" />
</head>
<footer id="footer" style="bottom:0px">
    <ul class="copyright" style="color:black">
        <li><a href="instruction.php">Instructions</a></li>
        <li><a href="contact.php">Contact us</a></li><li><a href="developer.php">Developers</a></li>
    </ul>
</footer>
<?php
if(isset($con)){
    mysqli_close($con);
}
if(isset($mysqli))
$mysqli->close();
?>