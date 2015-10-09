<header id="header" class="skel-layers-fixed">
    <h1 style="font-size:30px"><a href="index.php">HOSTEL-J</a><a href="http://www.thapar.edu" target="_blank" style="font-weight:100"> Thapar University</a></h1>
    <nav id="nav">
        <ul>
            <li><?php if (!isset($_SESSION['id']))
    header('location:index.php');
?>
                <a href="" class="icon fa-angle-down"><?php echo $_SESSION['name']; ?></a>
                <ul><?php if ($_SESSION['user_type'] == 'student') { ?>
                    <li><a href="complaint.php">New Complaints</a></li>
                    <li><a href="status.php">Existing Complaints</a></li>
                    <li><a href="profile.php">Account Settings</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <?php
                    } else if ($_SESSION['user_type'] == 'caretaker') {
                        ?>
                        <li><a href="caretaker.php">Complaints</a></li>
                        <li><a href="profile.php">Account Settings</a></li>
                        <li><a href="logout.php">Logout</a></li>
<?php } else if ($_SESSION['user_type'] == 'warden') { ?>
                        <li><a href="caretaker.php">Complaints</a></li>
                        <li><a href="addnew.php">Add Complaint Type</a></li>
                        <li><a href="delete.php">Delete Complaint Type</a></li>
                        <li><a href="clean.php">Clear Database</a></li>
                        <li><a href="profile.php">Account Settings</a></li>
                        <li><a href="logout.php">Logout</a></li>
<?php } ?>

                </ul>
            </li>
        </ul>
    </nav>
</header>
