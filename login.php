<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SESSION['user_type'] == 'student')
        header('location:complaint.php');
    else if ($_SESSION['user_type'] == 'caretaker')
        header('location:caretaker.php');
    if ($_SESSION['user_type'] == 'warden')
        header('location:warden.php');
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Home | SignIn</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <script src="js/login_js.js"></script>
        <?php include_once 'links.php'; ?>
    </head>
    <body>

        <!-- Header -->
        <header id="header" class="skel-layers-fixed">
            <h1 style="font-size:30px "><a href="index.php">HOSTEL-J</a><a href="http://www.thapar.edu" target="_blank" style="font-weight:100"> Thapar University</a></h1>
            <nav id="nav">      <h1 style="font-size:30px "><a href="index.php">HOSTEL-J</a><a href="http://www.thapar.edu" target="_blank" style="font-weight:100"> Thapar University</a></h1>

            </nav>
        </header>

        <!-- Main -->
        <section id="main" class="container small" >

            <header>
                <h2>Sign In</h2>
                <!--<p></p>-->
            </header>
            <div class="box">
                <form method="post" action="home.php">
                    <div class="row uniform half">
                        <div class="12u">
                            <input type="text" name="username" id="username" placeholder="Email" required/>
                        </div>
                    </div>
                    <div class="row uniform half">
                        <div class="12u">
                            <input type="password" name="password" id="password" placeholder="Password" onkeyup="if (event.keyCode == 13)
                                        document.getElementById('signin').click()" required/>
                        </div>
                    </div>

                    <div class="row uniform half">
                        <div class="12u">
                            <center>
                                <label id="incorrect" style="display:none;color:red">Incorrect Email ID or Password</label>
                            </center>
                        </div>
                    </div>
                    <div class="row uniform">
                        <div class="12u">
                            <ul class="actions align-center">

                                <li><a><input type="button" id="signin" onClick="val()" value="Sign In" /></a></li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- Footer -->
        <?php //require_once "footer.php"  ?>

    </body>
</html>