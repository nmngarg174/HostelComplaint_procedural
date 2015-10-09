<?php
    session_start();
		if (!isset($_SESSION['id']))
    header('location:index.php');
{
    if ($_SESSION['user_type'] == 'caretaker')
        header('location:caretaker.php');
    else if ($_SESSION['user_type'] == 'warden')
        header('location:warden.php');
}
if (!isset($_REQUEST['go'])) {
			if(!isset($_POST['type']))
			header("location:complaint.php");
 }
        include_once 'header.php';
        include_once 'con_procedural.php';
        include_once 'connection.php';
        include_once './links.php';
        require_once 'functions.php';
	$count = 0;
        if (!isset($_REQUEST['go'])) {
       if($_POST['message']=== '')
        {
            echo "<center><br /><br/><br /><br /><h2>Invalid Data.....Redirecting</h2></center>";
           echo "<script>setTimeout(function(){document.location.assign('complaint.php')}, 2000)</script>";die();
         }
$flag=0;
         if( $_POST['level']=='cluster' || $_POST['level']=='room')
         $flag=1;
         $q = mysqli_query($con,"select id from category where category='".$_POST['type']."'");
$row=mysqli_fetch_array($q);
           $num_results = mysqli_num_rows($q);
          if ($num_results ==0 || $flag==0){    echo "<center><br /><br/><br /><br /><h2>Invalid Data.....Redirecting</h2></center>";
           echo "<script>setTimeout(function(){document.location.assign('complaint.php')}, 2000)</script>";
die();}
         $_SESSION['type'] = $_POST['type'];
            $_SESSION['level'] = $_POST['level'];
            $_SESSION['msg'] = $_POST['message'];
        $name = $_SESSION['name'];
        $q1 = "select roomno from registration where regno =  '" . $_SESSION['roll'] . "'";
        $ret = mysqli_query($con, $q1) or die("Error in execution");
        $row = mysqli_fetch_array($ret);
        $room = $row['roomno'];
        $cluster = substr($room, 0, 4);
        
            if ($_POST['level'] == 'cluster')
$q = "select * from complaints where roomno like '" . $cluster . "%' and not(status='Complete') and category='" . $_SESSION['type'] . "' and comp_type='" . $_POST['level'] . "'";           
 else
                $q = "select * from complaints where roomno like '" . $room . "%' and not(status='Complete') and category='" . $_SESSION['type'] . "' and comp_type='" . $_POST['level'] . "'";
        
        $ret = mysqli_query($con, $q) or die("Error in execution");
        $count = mysqli_num_rows($ret);
		}
        if ($count > 0) {
            ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>CT|Complaints</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <?php include_once './links.php'; ?>
        <script src="js/print.js"></script>
        <script type="text/javascript" src="js/jquery.tablesorter.js"></script>
        <script type="text/javascript">$(function() {
                $('#keywords').tablesorter({debug: true});
            });</script>
        <script src="js/complaint_ct.js" type="text/javascript"></script>
    </head>
    <body>

            <section class="box" id="print">
                <div class="table-wrapper">
                    <center><h2 >Complaints similar to yours were found</h2></center>
                    <table id="keywords" class="tablesorter" >
                        <thead>
                            <tr>
                               <!-- <th><input type="checkbox" id="all"><label></label> </th>-->
                                <th>Complaint Id</th>
                                <th>Category</th>
                                <th>Room No</th>
                                <th>Details</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($ret)) {
                                ?>
                                <tr>
                                                               <!-- <td><input type="checkbox" id="1" name="all" onclick="check()"/><label></label> </td>-->
                                    <td><?php echo $row['comp_id']; ?></td>
                                    <td><?php echo $row['category']; ?></td>
                                    <td><?php echo $row['roomno']; ?></td>
                                    <td><?php echo $row['details']; ?></td>
                                    <td><?php echo format_date($row['comp_date']); ?></td>
                                    <td><?php
                                        if ($row['status'] == 'Pending')
                                                    echo "<b style='color:blue' >" . $row['status'] . "</b>";
                                                else if ($row['status'] == 'Complete')
                                                    echo "<b style='color:green'>" . $row['status'] . "</b>";
                                                else if ($row['status'] == 'Urgent')
                                                    echo "<b style='color:red'>" . $row['status'] . "</b>";
                                                else
                                                    echo $row['status'];
                                        ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" >
                    <center><ul class="actions">
                            <li>
                                <input type="hidden" value="go" name="go"/></li>
                           
                                   <?php if($_SESSION['type']=="Electricity" || $_SESSION['type']=="Miscellaneous") echo ' <li><a><input type="submit" class="button" value="Still Submit"  /></a></li>'; ?>
                            <li><a>
                                    <input type="button" class="button" value="Go back" onclick='window.location.assign("complaint.php")' /></a></li>
                        </ul>
<b><p style="color:red">Warning : Do not submit the same cluster complaint if it has already been registered. Defaulters will be issued a heavy fine. </p></b>
</center>
                </form></div>
            </section>

            <?php
        }
        else {
            unset($_REQUEST['go']);
            ?>

             <?php
              $q1 = "select login_date,count from login where email ='".$_SESSION['email'] . "'"; 
              $ret = mysqli_query($con, $q1) or die("Error in execution");
              $row = mysqli_fetch_array($ret);

              if($row['login_date']==date('Y-m-d'))
              { 
               if($row['count']>=2)
              {
              echo "<center><br /><br/><br /><br /><h2>You have exceeded the daily complaint limit of 2.....Redirecting</h2></center>";
              echo"<script> setTimeout(function(){document.location.assign('complaint.php')}, 2000)</script>"; exit(0);
             }
             }
              else
{
              $ret=mysqli_query($con,"update login set login_date='".date('Y-m-d')."',count=0 where email='".$_SESSION['email']."'");

}
            echo "<center><br /><br/><br /><br /><h2>Complaint added Successfully.....Redirecting</h2></center>";
            $ret=mysqli_query($con,"update login set count=count+1 where email='".$_SESSION['email']."'");
            $q1 = "select roomno from registration where regno =  '" . $_SESSION['roll'] . "'";
            $ret = mysqli_query($con, $q1) or die("Error in execution");
            $row = mysqli_fetch_array($ret);
            $room = $row['roomno'];
            $name = $_SESSION['name'];

            $q = $mysqli->prepare("insert into complaints(category, roomno,  details, name, comp_type,comp_date) values (?,?,?,?,?,?)");
            $q->bind_param('ssssss', $cat, $roomno, $det, $nam, $type,date('Y-m-d H:i:s'));
            $cat = $_SESSION['type'];
            $roomno = $room;
            $det_with_comma = string_validate($_SESSION['msg']);
$det = str_replace(",", ";",$det_with_comma);
            $nam = $name;
            if($roomno=="Mess")
            $type="Mess";
            else
            $type = $_SESSION['level'];
           
            $q->execute();
            //echo $q->error."   ".$q->affected_rows;
            unset($_SESSION['type']);
            unset($_SESSION['msg']);
            unset($_SESSION['level']);
            echo"<script> setTimeout(function(){document.location.assign('complaint.php')}, 2000)</script>";
        }
        ?>
    </body>
</html>