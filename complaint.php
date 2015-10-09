<?php
session_start();
if (!isset($_SESSION['id']))
    header('location:index.php');
else
{
    if ($_SESSION['user_type'] == 'caretaker')
        header('location:caretaker.php');
    else if ($_SESSION['user_type'] == 'warden')
        header('location:warden.php');
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Home | New Complaint</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <script language="javascript" type="text/javascript">
function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
		document.getElementById("count").innerHTML = "(Maximum characters: 60) You have "+limitCount.value+" characters left.";
	}
}
</script>
        <?php include_once 'links.php' ; ?>
    </head>
<?php include_once 'header.php';    
require_once './functions.php';    
include_once './con_procedural.php'; ?>
    
    <body>

        <!-- Main -->
        <section id="main" class="container small">
            <header>
                <h2>New complaint</h2>
            </header>
            <ul class="actions" style="text-align:center">
                <?php
                $sql = 'SELECT * FROM category where level = "rc"';
                $retval = mysqli_query($con, $sql) or die('Could not get data: ' . mysqli_error($con));
 $sql1 = 'SELECT * FROM category where level = "cluster"';
                $retval1 = mysqli_query($con, $sql1) or die('Could not get data: ' . mysqli_error($con));
                ?>

                <ul class="actions" style="text-align:center">

                    <?php
                    while ($row = mysqli_fetch_array($retval)) {
                        ?>
                        <li><input type="button" style = "width: 200px" class="special" onClick="changeRC()" value="<?php echo $row['category']; ?>"/></li>
                        <?php
                    }
                    ?>
 <?php
                    while ($row1 = mysqli_fetch_array($retval1)) {
                        ?>
                        <li><input type="button" style = "width: 200px" class="special" onClick="changeCluster()" value="<?php echo $row1['category']; ?>"/></li>
                        <?php
                    }
                    ?>
                </ul>
        </section>
        <section class="container small">
            <div class="box">

                <form method="post" action="check_comp.php" name="complaint" id="complaint">
                    <div id="type"><h3>Electricity</h3>
                        <input type="hidden" name="type" value="Electricity"/>
                    </div>

                    <div id="room_cluster" class="row uniform half collapse-at-2">
                        <div class="6u">
                            <input type="radio" id="room" name="level" value="room">
                            <label for="room">Room</label>
                        </div>
                        <div class="6u">
                            <input type="radio" id="cluster" name="level" checked="true"  value="cluster">
                            <label for="cluster">Cluster</label>
                        </div>

                    </div>
                    <div class="row uniform half">
                        <div class="12u">
                            <textarea maxlength="60" name="message" id="message" placeholder="Type your complaint here..." rows="4" required onKeyDown="limitText(this.form.message,this.form.countdown,60);" 
onKeyUp="limitText(this.form.message,this.form.countdown,60);">
</textarea>
<input type="hidden" name="countdown" value="60">
<div id ="count" name="count">(Maximum characters: 60) You have 60 characters left.</div>
                        </div>
                    </div>
                    <div class="row uniform">
                        <div class="12u">
                            <ul class="actions align-center">
                                <li><input type="submit" value="Submit" /></li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>

        </section>
        <script>
            function changeRC() {
                var type = document.activeElement.value;
                document.getElementById("complaint").reset();
                document.getElementById("type").innerHTML = "<h3>" + type + "</h3>" + "<input type=\"hidden\" name=\"type\" value=" + type + ">";
                    document.getElementById("room_cluster").style.display = "block";
                
            }
function changeCluster() {
                var type = document.activeElement.value;
                document.getElementById("complaint").reset();
                document.getElementById("type").innerHTML = "<h3>" + type + "</h3>" + "<input type=\"hidden\" name=\"type\" value='" + type + "'>";
                    document.getElementById("room_cluster").style.display = "none";
                
            }
        </script>

        <!-- Footer -->
<?php require_once "footer.php" ?>

    </body>
</html>