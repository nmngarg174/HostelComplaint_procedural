<?php
if (session_id() == '') {
    session_start();
}
if (!isset($_SESSION['id']))
    header('location:index.php');
else {
    if ($_SESSION['user_type'] == 'student')
        header('location:complaint.php');
    else if ($_SESSION['user_type'] == 'warden')
        header('location:warden.php');
$rec_limit = 15;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>CT|Complaints</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <?php include_once 'links.php'; ?>
        <script src="js/print.js"></script>
        <script src="js/jquery.tablesorter.js"></script>
        <script>$(function() {
                $('#keywords').tablesorter({debug: true});
            });</script>
        <script src="js/complaint_ct.js"></script>
    </head>
    <?php include_once 'header.php';
    include_once './con_procedural.php';
    require_once './functions.php'; ?> 
    <body>

        <?php
        $sql = 'SELECT * FROM category';

        $retval = mysqli_query($con, $sql) or die('Could not get data: ' . mysqli_error($con));
        ?>
        <section id="main" class="container large">
            <div class="row">
                <div class="12u" id="filter">
                    <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="form">
                        <section class="box" style="padding-top: 15px; padding-bottom: 15px; ">

                            <h1>
                                Filters
                            </h1>

                            <div class="row">
                        <div class="4u">
                        
                        <select class="dd" name="fcat">
                            <option hidden="" value="<?php if(isset($_REQUEST['fcat']))echo $_REQUEST['fcat']; else echo ""?>"><?php if(isset($_REQUEST['fcat'])&&$_REQUEST['fcat']!=''){echo $_REQUEST['fcat'];}else echo "Category";?></option>
                            <?php while ($row = mysqli_fetch_array($retval)) { ?>
                                <option value="<?php echo $row['category']; ?>"><?php echo $row['category']; ?></option>
                            <?php } ?>
                            <option value="">All</option>
                        </select> </div>
                       <div class="4u">
                        
                        <select class="dd" name="fwing">
                            <option hidden="" value="<?php if(isset($_REQUEST['fwing']))echo $_REQUEST['fwing']; else echo ""?>"><?php if(isset($_REQUEST['fwing'])&&$_REQUEST['fwing']!=''){echo $_REQUEST['fwing'];}else echo "Wing";?></option>                            
                            <option value="West" >West</option>
                            <option value="East" >East</option>
                            <option value="">All</option>
                        </select>
                        </div>
                        <div class="4u">
                        <select class="dd" name="fstat">
                            <option hidden="" value="<?php if(isset($_REQUEST['fstat']))echo $_REQUEST['fstat']; else echo ""?>"><?php if(isset($_REQUEST['fstat'])&&$_REQUEST['fstat']!=''){echo $_REQUEST['fstat'];}else echo "Status";?></option>                            
                            <option value="Pending">Pending</option>
                            <option value="Waiting">Waiting</option>
                            <option value="Complete">Completed</option>
                            <option value="Urgent">Urgent</option>
                           <option value="">All</option> 
                        </select>
                        </div></div>
                        
                        <div style="margin-bottom:20px"> Sort complaints from
                            <br />
                          <div class="row"> <div class="4u"> <input type="date" name="f_sdate" value="<?php if(isset($_REQUEST['f_sdate']))echo $_REQUEST['f_sdate'];?>"/></div><div class="4u"> <input type="date" id="f_edate" name="f_edate" value="<?php if(isset($_REQUEST['f_edate']))echo $_REQUEST['f_edate'];?>"/></div>
                        <div class="4u">
                        <ul class="actions" >
                        	<li class="4u"><a onclick="document.getElementById('form').submit()" class="button" >Search</a></li>
                        	<li class="3u" style="margin-right: 20px;"><a href="caretaker.php" class="button" >Reset</a></li>
                        	<li class="3u"><a class="button" onclick="printDiv('print')" >Print</a></li>
                        </ul>
                      </div>
                      </div>

                    </section>
                    </form>
                </div>
                </div>

            <!---------------------------------------- POPUP start ------------------------->

            <div id="shadow" style="height:100%;width:100%;background-color:#666;z-index:3;opacity:.8;display:none;position:fixed;top:0px; left: 0px;" onclick="hide()">
            </div>
            <div id="popup" style="text-align:center; width:80%; display:none; z-index:4; position:absolute; background-color: inherit; top: 10%; margin-left:10% ; padding: 0px;">
                <div style="float:right; position:relative; top:30px;"><img src="images/cross.gif" onClick="hide()" style="cursor:pointer"> </div>


                <table style="text-align:center">
                    <tr>
                        <th>Name</th>
                        <th>Complaint Id</th>
                        <th>Category</th>
                        <th>Room No</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                    <tr id="ajaxdata">
                    </tr>
                </table>
                <div class="box">
                    <div class="row uniform">
                        <div class="12u">
                            <h2>Remarks</h2>
                            <table style="text-align:center" id="getremark">

                            </table>            
                        </div>
                    </div>
                </div>
                <center>
                    <div class="box">
                        <form >
                            <div class="row uniform">
                                <div class="4u">
                                    <div class="12u">
                                        Expected Completion Date
                                        <input type="date" name="complete" id="complete" required="required"/></div><br />
                                    <div class="12u">
                                        <select class="dd" id="status">
                                            <option value="" hidden="">Status</option>
                                            <option value="Waiting" >Waiting</option>
                                            <option value="Complete">Completed</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="8u">
                                    <textarea placeholder="Remarks" id="remark" rows="4"></textarea>
                                </div>

                            </div>
                            <br />

                            <input type="button" class="button" value="Update" onclick="update()"/>&nbsp;&nbsp;
                            <input type="button" class="button" value="Close" onclick="hide()"/>
                        </form> 
                    </div>
            </div>

            <!---------------------------------------- POPUP end ------------------------->
            


                                    <!---------------------------------Filters start---------------------------------------->             
                                    <?php
                                    $cat = $wing = $stat = $sdate = $edate = "";
                                    if (isset($_REQUEST['fcat'])) {
                                        $cat = $_REQUEST['fcat'];
                                    }
                                    if (isset($_REQUEST['fwing']))
                                        $wing = substr($_REQUEST['fwing'], 0, 1);
                                    if (isset($_REQUEST['fstat']))
                                        $stat = $_REQUEST['fstat'];
                                    if (isset($_REQUEST['f_sdate']) && isset($_REQUEST['f_edate'])) {
                                        $sdate = date("Y-m-d H:i:s", strtotime($_REQUEST['f_sdate']));
                                        $edate = date("Y-m-d H:i:s", strtotime($_REQUEST['f_edate']));
                                    } else {
                                        $sdate = '1970-01-01 05:30:00';
                                        $edate = '1970-01-01 05:30:00';
                                    }
                                    $sql = 'select * from complaints where ';
                                    if ($cat != "") {
                                        $sql = $sql . 'category = "' . $cat . '" ';
                                    }



                                    if ($wing != '' && $sql != 'select * from complaints where ')
                                        $sql = $sql . "and roomno like '" . $wing . "%' ";
                                    else if ($wing != "")
                                        $sql = $sql . "roomno like '" . $wing . "%' ";

                                    if ($stat != "" && $sql != 'select * from complaints where ')
                                        $sql = $sql . "and status = '" . $stat . "' ";
                                    else if ($stat != "")
                                        $sql = $sql . "status = '" . $stat . "' ";

                                    if ($stat == "" && $sql != 'select * from complaints where ')
                                        $sql = $sql . "and status <>'Complete'";
                                    else if ($stat == "")
                                        $sql = $sql . "status <>'Complete'";
                                    if ($sql != 'select * from complaints where ' && $sdate != '1970-01-01 05:30:00' && $edate != '1970-01-01 05:30:00')
                                        $sql = $sql . " and comp_date between '" . $sdate . "'  and DATE_ADD('" . $edate . "', INTERVAL 1 DAY)";
                                    else if ($sql == 'select * from complaints where ' && $sdate != '1970-01-01 05:30:00' && $edate != '1970-01-01 05:30:00')
                                        $sql = $sql . "comp_date between '" . $sdate . "'  and DATE_ADD('" . $edate . "', INTERVAL 1 DAY)";
                                    else if ($sql == 'select * from complaints where ')
                                        $sql = 'select * from complaints where status <>"Complete"';
                                  
                                  //echo $sql;
                                  $sql1=str_replace("*","count(comp_id)",$sql);
                                 
                                    $retval = mysqli_query($con, $sql1) or die('Could not get data: ' . mysqli_error($con));
									$row = mysqli_fetch_array($retval);
									
									
//////////////////////////////////////////////Pagination start///////////////////////////////////////////
									$rec_count = $row[0];
echo '<div class="row">
                <div class="12u" >
                    <section class="box" id="print">
 <h1 style="font-size:32px;text-align:center;margin-top:0px">
                                Complaints - '.$rec_count.'
                            </h1>';	
									if( isset($_GET{'page'} ) )
									{
									   $page = $_GET{'page'} + 1;
									   $offset = $rec_limit * $page ;
									}
									else
									{
									   $page = 0;
									   $offset = 0;
									}
									$left_rec = $rec_count - ($page * $rec_limit);
                                                                        echo "<center>";
									if( $left_rec < $rec_limit && $rec_count>$rec_limit )
									{
									   $last = $page - 2;
									   echo '<a href="'.	$_SERVER["PHP_SELF"].'?fcat='.$_REQUEST["fcat"].'&fwing='.$_REQUEST["fwing"].'&fstat='.$_REQUEST["fstat"].'&f_sdate='.$_REQUEST["f_sdate"].'&f_edate='.$_REQUEST["f_edate"].'&page='.$last.'">Previous '.$rec_limit.' Records</a>';
									}
									else if( $page > 0 )
									{
									   $last = $page - 2;
									   echo '<a href="'.$_SERVER["PHP_SELF"].'?fcat='.$_REQUEST["fcat"].'&fwing='.$_REQUEST["fwing"].'&fstat='.$_REQUEST["fstat"].'&f_sdate='.$_REQUEST["f_sdate"].'&f_edate='.$_REQUEST["f_edate"].'&page='.$last.'">Previous '.$rec_limit.' Records</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
									   echo '<a href="'.$_SERVER["PHP_SELF"].'?fcat='.$_REQUEST["fcat"].'&fwing='.$_REQUEST["fwing"].'&fstat='.$_REQUEST["fstat"].'&f_sdate='.$_REQUEST["f_sdate"].'&f_edate='.$_REQUEST["f_edate"].'&page='.$page.'">Next '.$rec_limit.' Records</a>';
									}
									else if( $page == 0 && $rec_count>$rec_limit )
									{
									   echo '<a href="'.$_SERVER["PHP_SELF"].'?fcat='.$_REQUEST["fcat"].'&fwing='.$_REQUEST["fwing"].'&fstat='.$_REQUEST["fstat"].'&f_sdate='.$_REQUEST["f_sdate"].'&f_edate='.$_REQUEST["f_edate"].'&page='.$page.'">Next '.$rec_limit.' Records</a>';
									}
                                                                        echo "</center>";
									$sql = $sql.' order by case when status="Urgent" then 1 else 2 end,comp_date ' . ' LIMIT '.$offset.', '.$rec_limit;
									//echo $sql;
 if($rec_count>0)
                                                                       {
									$retval = mysqli_query($con, $sql) or die('Could not get data: ' . mysqli_error($con));
$sum=$offset+$rec_limit;
if($sum>$rec_count)
$sum=$rec_count;
$add=$offset+1;
echo "<center> Showing ".$add." to ".$sum." records</center>";
/////////////////////////////////////////Pagination end///////////////////////////////////////////////////                      
									
								?>


<div class="table-wrapper">
                                        <table id="keywords" class="tablesorter" style="width:100%">
                                <thead>
                                    <tr>
                                       <!-- <th><input type="checkbox" id="all"><label></label> </th>-->
                                        <th>Complaint Id</th>
                                        <th>Category</th>
                                        <th>Details</th>
                                        <th>Room No</th>
                                        <th>Complaint Type</th>
                                        <th>Contact No</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody style="color:black;font-weight:400">

                                    <!---------------------------------------Filters end----------------------------------------------->                         
                                    <?php while ($row = mysqli_fetch_array($retval)) {
                                        $ret1=mysqli_query($con,"select contact from registration where roomno='".$row['roomno']."'");
                                        $row1=mysqli_fetch_array($ret1)
                                        ?>
                                        <tr>
                                           <!-- <td><input type="checkbox" id="1" name="all" onclick="check()"/><label></label> </td>-->
                                            <td><a onclick="show(<?php echo $row['comp_id']; ?>)"><?php echo $row['comp_id']; ?></a></td>
                                            <td><?php echo $row['category']; ?></td>
                                            <td><?php echo str_replace(array("\\r\\n","\\r","\\n"), "<br>",$row['details']); ?></td>
                                            <td><?php echo $row['roomno']; ?></td>
                                            <td><?php echo $row['comp_type']; ?></td>
                                            <td><?php echo $row1['contact']; ?></td>
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
<?php }} else echo "<br><center><h1>No Records found</h1></center>";?>

                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
            </div>
            </center>
        </section>
<?php require_once "footer.php" ?>           
    </body>
</html>