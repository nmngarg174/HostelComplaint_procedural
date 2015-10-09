<?php
if (session_id() == '') {
    session_start();
}
if (!isset($_SESSION['id']))
    header('location:index.php'); {
    if ($_SESSION['user_type'] == 'caretaker')
        header('location:caretaker.php');
    else if ($_SESSION['user_type'] == 'warden')
        header('location:warden.php');
}
?>
<!DOCTYPE HTML>

<html>
    <head>
        <title>Home | Complaints</title>

        <meta name="description" content="" />
        <meta name="keywords" content="" />        
        <script type="text/javascript" src="js/jquery.tablesorter.js"></script>
        <script type="text/javascript">$(function() {
                $('#keywords').tablesorter({debug: true});
            });</script>
        <script src="js/complaint_ct.js" type="text/javascript"></script>
<?php        include_once 'links.php'; ?>
    </head>
    <body>

        <!-- Header -->
        <?php
        include_once "header.php";
        require_once 'functions.php';
        include_once 'con_procedural.php';
        ?>

        <!-- Main -->
        <section id="main" class="container large">
            <header>
                <h2>Complaints Status</h2>
                <!--<p></p>-->
            </header>

        </section>

        <div class="12u">

            <!-- Table -->
            <section class="box">
                <?php
                $sql = 'SELECT * FROM complaints,registration where registration.regno="' . $_SESSION['roll'] . '" and registration.roomno=complaints.roomno order by comp_date desc';

                $retval = mysqli_query($con, $sql) or die('Could not get data: ' . mysqli_error($con));
                $counter = mysqli_num_rows($retval);
                if ($counter != 0) {
                    ?>

                    <div class="table-wrapper">
                        <table id="keywords" class="tablesorter">
                            <thead>
                                <tr>
                                    <th>Date and Time</th>
                                    <th>Complaint Id</th>
                                    <th>Type</th>
                                    <th>Details</th>
                                    <th>Remarks</th>
                                    <th>Status</th>
                                    <th>Expected Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_array($retval)) {
                                     $ret1 = mysqli_query($con,"select * from remarks where comp_id='".$row['comp_id']."' order by time desc");
                                     $count=mysqli_num_rows($ret1);
                                    ?>
                                    <tr>
                                        <td><?php echo format_date($row['comp_date']); ?></td>
                                        <td><?php echo $row['comp_id']; ?></td>
                                        <td><?php echo $row['category']; ?></td>
                                        <td><?php echo str_replace(array("\\r\\n","\\r","\\n"), "<br>",$row['details']); ?></td>
                                        <td><?php if($count>0)while($row1 = mysqli_fetch_array($ret1)){ echo "<b>".$row1['user_type']."</b>(".format_date($row1['time']).") :  ".$row1['remark']."<br>";} else echo "None";?></td>
                                        <td><?php
                                            if ($row['status'] == 'Pending')
                                                echo "<b style='color:blue'>" . $row['status'] . "</b>";
                                            else if ($row['status'] == 'Complete')
                                                echo "<b style='color:green'>" . $row['status'] . "</b>";
                                            else if ($row['status'] == 'Urgent')
                                                echo "<b style='color:red'>" . $row['status'] . "</b>";
                                            else
                                                echo $row['status'];
                                            ?></td>
                                         <td><?php if($row['exp_date'] == "Not Set") echo $row['exp_date']; else  echo format_date($row['exp_date']); ?></td>
                                    </tr> 
                            <?php
                            }
                        }
                        else {
                            ?>
                            <center><p>No complaints added yet...</p></center>
<?php } ?>

                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>


    <!-- Footer -->
<?php require_once "footer.php" ?>

</body>

</html>