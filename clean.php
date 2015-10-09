<?php
if (session_id() == '') {
    session_start();
}
if (!isset($_SESSION['id'])) {
    header('location:index.php');
} else {
    if ($_SESSION['user_type'] == 'student') {
        header('location:complaint.php');
    } else if ($_SESSION['user_type'] == 'caretaker') {
        header('location:caretaker.php');
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Delete Complaints</title>
<?php include_once 'links.php'; ?>
<script>
function allClear() {
    var x;
    if (confirm("Are you sure you want to delete all complaints?") == true) {
        document.getElementById("all").submit();
    } else {
        x = "You pressed Cancel!";
    }
    
}
function compClear() {
    var x;
    if (confirm("Are you sure you want to delete all completed complaints?") == true) {
        document.getElementById("comp").submit();
    } else {
        x = "You pressed Cancel!";
    }
    
}
</script>
</head>
<?php
    include_once 'header.php';
    require_once './functions.php';
    include_once 'con_procedural.php';
    ?> 
<body>
<section id="main" class="container small" >
<header>
    <h3 style="margin-bottom:0px;">Clean Database</h3>
</header>

<?php
if(isset($_REQUEST['clean']))
{
$id = $_REQUEST['clean'];
if($id=="all"){
$q = $mysqli->prepare("truncate complaints");
$q->execute();
}
else if($id=="comp"){
$q = $mysqli->prepare("delete from complaints where status='Complete'");
$q->execute();
}
}
?>
<div class="box">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="all">
<input type="hidden" value="all" name="clean">
<input type="button" class="button special" value="Click here" onClick="allClear()"> to delete all complaints (Empty the table) <br>
 </form>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="comp">
<input type="hidden" value="comp" name="clean">
<input type="button" class="button special" value="Click here" onClick="compClear()"> to delete all completed complaints <br>
 </form>
</div>
</section>
</body>
</html>