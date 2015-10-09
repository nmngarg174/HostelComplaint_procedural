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
        <title>Warden | Add Complaint Category</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <?php include_once 'links.php'; ?>
    </head>

    <body>
        <section id="main" class="container small" >
            <?php include_once "header.php";
            include_once './connection.php'; 
            require_once 'functions.php'?>
            <header>
                <h3 style="margin-bottom:0px;">Add new complaint category</h3>
                <?php if (isset($_REQUEST['category']) && isset($_REQUEST['level'])) {
                    echo "<p style=\"margin-bottom:0px;\">New Category Added Successfully! </p>";
                } ?>
            </header>
            <div class="box">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="row uniform half">
                        <div class="12u">
                            <input type="text" name="category" id="category" placeholder="Category Name" required/>
                        </div>
                    </div>
                    <div class="row uniform half">
                        <div class="12u">
                            <select name="level" class="dd" required>
                                <option hidden="">Level</option>
                                <option value="cluster">Cluster</option>
                                <option value="rc">Room and Cluster</option>
                            </select>
                        </div>
                    </div>

                    <div class="row uniform">
                        <div class="12u">
                            <ul class="actions align-center">
                                <li><input type="submit" value="Add Category" /></li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <?php
        if (isset($_REQUEST['category']) && isset($_REQUEST['level'])) {
            $q = $mysqli->prepare("insert into category (category, level) values (?,?)");
            $q->bind_param('ss', $category, $level);
            $category = string_validate($_REQUEST['category']);
            $level = $_REQUEST['level'];
            $q->execute();
        }
        ?>

        <!-- Footer -->
<?php require_once "footer.php" ?>

    </body>
</html>