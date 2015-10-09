<?php
if (session_id() == '') {
    session_start();
}
if (!isset($_SESSION['id']))
    header('location:index.php');
else {
    if ($_SESSION['user_type'] == 'student')
        header('location:complaint.php');
    else if ($_SESSION['user_type'] == 'caretaker')
        header('location:caretaker.php');
}
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Warden | Delete Category</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <?php include_once 'links.php'; ?>
    </head>

    <body>
        <section id="main" class="container small" >
            <?php include_once "header.php";
            include_once './connection.php'; 
            include_once 'functions.php';?>
            <header>
            <?php
        if (isset($_REQUEST['category'])) {
            $q = $mysqli->prepare("delete from category where category = (?)");
            $q->bind_param('s', $category);
            $category = string_validate($_REQUEST['category']);
            $q->execute();
        }
        ?>
                <h3 style="margin-bottom:0px;">Remove complaint category</h3>
                <?php if (isset($_REQUEST['category'])) {
                    echo "<p style=\"margin-bottom:0px;\">Category Deleted Successfully! </p>";
                } ?>
            </header>
            <div class="box">
                <h5>Select the category to remove and click on delete.</h5>
                <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <table>
                    <?php 
					$q = $mysqli->prepare("select category from category");
            		$q->execute();
					$q->bind_result($cat);
					$i=1;
					echo "<tr>";
					while ($q->fetch()) {
						echo '<td><input type="radio" id="'.$cat.'" name="category" value="'.$cat.'"><label for="'.$cat.'">' . $cat . '</label></td>';
						if($i%3 ==0)
						echo "</tr><tr>";
						$i++;
					}
					echo "</tr>";
					
					?>
                    </table>
                    <input type="submit" class="special" value="Delete">
                </form>
            </div>
        </section>
        

        <!-- Footer -->
<?php require_once "footer.php" ?>

    </body>
</html>