<?php
if (session_id() == '') {
    session_start();
}
if (!isset($_SESSION['id']))
    header('location:index.php');
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Account</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
       <script language="javascript">
function passwordChanged(id) {
var strength = document.getElementById(id);
var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[@#$%^&*]).*$", "g");
var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
var enoughRegex = new RegExp("(?=.{6,}).*", "g");
var pwd = document.getElementById(id);
if (strongRegex.test(pwd.value)) {
strength.className = "strong";
} else if (mediumRegex.test(pwd.value)) {
strength.className = "medium";
} else {
strength.className = "weak";
}
}
</script>
		
        <?php include_once 'links.php'; ?>
		<link rel="stylesheet" href="css/strength.css" >
    </head>
    <body>

        <!-- Header -->
        <?php include_once("header.php");
 include_once 'con_procedural.php';
        ?>
        <?php
        $query = "select pass from login where email = '" . $_SESSION['email'] . "'";
        $q = mysqli_query($con, $query) or die(mysqli_error($con));
        $row = mysqli_fetch_array($q);
		 $query1= "select * from registration where email = '" . $_SESSION['email'] . "'";
        $q1 = mysqli_query($con, $query1) or die(mysqli_error($con));
        $row1 = mysqli_fetch_array($q1);
        if (!isset($_POST['pass'])) {
            $passerr = "";
        }
		if (!isset($_POST['oldpass'])) {
            $olderr = "";
        }
		if (!isset($_POST['repass'])) {
            $matcherr = "";
        }
		
        function valid_pass($candidate) {
            if (!preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[\d])(?=\S*[\W])\S*$', $candidate))
                return FALSE;
            return TRUE;
        }

        /*
          Explaining $\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$
          $ = beginning of string
          \S* = any set of characters
          (?=\S{8,}) = of at least length 8
          (?=\S*[a-z]) = containing at least one lowercase letter

          (?=\S*[\d]) = and at least one number
          (?=\S*[\W]) = and at least a special character (non-word characters)
          $ = end of the string

         */

        // update password
		if(isset($_POST['oldpass']))
		{
			$oldpass = $_POST['oldpass'];
			$salt = "thispasswordcannotbehacked";
            $oldpass = hash('sha256', $salt . $oldpass);
			if($oldpass == $row['pass'])
				$olderr = "";
			else {
				 $olderr = "Your password doesnot match your previous password.";
				}
			
		
        if (isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['repass']) ) {
            $pass = $_POST['pass'];
			$repass = $_POST['repass'];
			if($pass == $repass){
				$matcherr = "";
			}
			else {
				$matcherr = "Passwords do not match. Please try again";
			}
            if (valid_pass($pass)) {
                $passerr = "";
            } else
                $passerr = "Password is not valid. ";
            if ($passerr == "") {
                $salt = "thispasswordcannotbehacked";
                $pass = hash('sha256', $salt . $pass);
                $query1 = "update login set pass = '" . $pass . "' where email = '" . $_SESSION['email'] . "'";
                $q1 = mysqli_query($con, $query1) or die(mysqli_error($con));
                $success = "Your changes have been saved";
            }
        
		}
		}	
		
        ?>
        <!-- Main -->
        <section id="main" class="container small">
            <header>
                <h2>Change password</h2>
<?php 
    echo $success;

?>

            </header>
            <div class="box">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row uniform half collapse-at-2">
                        <div class="12u">
                            <input type="text" name="name" id="name" value="<?php echo $_SESSION['name']; ?>" readonly/>
                        </div>
                    </div>
                    <div class="row uniform half collapse-at-2">
                        <div class="12u">
                            <input type="email" name="email" id="email" value="<?php echo $_SESSION['email']; ?>" readonly />
                        </div>
                    </div>
                    <div class="row uniform half collapse-at-2">
                        <div class="12u">
                            <input type="text" name="mob" id="mob" value="<?php echo $row1['contact']; ?>"  readonly/>
                        </div>
                    </div>
                    <div class="row uniform half">
                        <div class="12u">
                            <input type="password" name="oldpass" id="oldpass" placeholder="Enter old password" required />
                        </div>
                         <span class="error"><?php echo $olderr; ?> </span>
                    </div>

                    <div class="row uniform half">
                        <div class="12u">
                            <input type="password" name="pass" id="pass" placeholder="Enter new password" maxlength="20"  onkeyup="return passwordChanged('pass');"  required />
                        </div>
                        <span class="error"><?php echo $passerr; ?> Password : atleast 1 number, 1 special character, 1 lowercase alphabet and minimum length is 8</span>
                    </div>
                    <div class="row uniform half">
                        <div class="12u">
                            <input type="password" name="repass" id="repass" placeholder="Confirm password" maxlength="20" onkeyup="return passwordChanged('repass');" required />
                        </div>
                         <span class="error"><?php echo $matcherr; ?> </span>
                    </div>
                    
                    <div class="row uniform">
                        <div class="12u">
                            <ul class="actions align-center">
                                <li><input type="submit" value="Update" /></li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </section>


        <!-- Footer -->
        <?php require_once "footer.php" ?>

    </body>
</html>