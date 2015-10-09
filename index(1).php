<?php
session_start();
if (isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] == 'student')
        header('location:complaint.php');
    else if ($_SESSION['user_type'] == 'caretaker')
        header('location:caretaker.php');
    else if ($_SESSION['user_type'] == 'warden')
        header('location:warden.php');
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Hostel J</title>
        <link rel="shortcut icon" href="favicon.ico" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <?php include_once 'links.php'; ?>
<style>
html, body {
    max-width: 100%;
    overflow-x: hidden;
}
</style>
    </head>
    <body class="landing">

        <!-- Header -->
        <header id="header" class="alt">
            <h1 style="font-size:30px "><a href="index.php">HOSTEL-J</a><a href="http://www.thapar.edu" target="_blank" style="font-weight:100"> Thapar University</a></h1>
			       <nav id="nav">      <h1 style="font-size:30px "><a href="login.php">Sign In</a><a href="http://www.thapar.edu" target="_blank" style="font-weight:100"> Thapar University</a></nav></h1>
        </header>

        <!-- Banner -->
        <section id="banner">
<marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();" style="position:absolute; top: 0; z-index: 20000; color: blue; font-weight: bold;">Registrations for the hostel rooms allotment will start on <font color="red">Saturday (16 May, 2015).</font> For any query contact Saurabh (+91-9041544335) </marquee>

            <b><h2>Online Hostel J</h2></b><br>
            <p><i>Registering Complaints Was Never So Easy!</i><br>Please read instructions before continuing. <a href="instruction.php" style="color:blue">Click here to view Instructions</a></p>
            <ul class="actions">
                <li><a href="login.php" class="button special">Sign In (For Complaints)</a>&nbsp &nbsp <a href="http://book.onlinehostelj.in" class="button special">Online Hostel Allotment</a></li>
            </ul>
            
        </section><br><br><br>

        <!-- Main -->
        <section id="main" class="container">

            <section class="box special">
                <header class="major">
                    <h2>Introducing&nbsp; the&nbsp; new&nbsp; solution
                        <br />
                        for&nbsp; your&nbsp; complaints</h2>

                </header>
                <span class="image newfeatured"><img src="images/pic01.jpg" alt="" /></span>
            </section>
        </section>
        <!-- Footer -->
        <footer id="footer" style="bottom:0px">
            <ul class="copyright" style="color:black">
                <li><a href="instruction.php">Instructions</a></li>
                <li><a href="contact.php">Contact us</a></li><li><a href="developer.php">Developers</a></li>
            </ul>
        </footer>

    </body>
</html>