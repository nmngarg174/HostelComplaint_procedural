<?php 

if(!isset($_COOKIE['count'])){
	setcookie('count', $c ,time() + (3600), "/");
	}
?>



<!DOCTYPE HTML>
<html>
    <head>
        <title>Contact Us</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <script>
		function spam_alert(){
			alert("To prevent spamming, we allow atmost 3 feedbacks in 8 hours from 1 machine");	
			window.location.assign("index.php");				
		}
        </script>
        <?php include_once 'links.php'; ?>
    </head>
    <body>
        <?php require_once 'functions.php'; include_once './connection.php';?>
        <!-- Header -->
        <header id="header" class="skel-layers-fixed">
            <h1 style="font-size:30px "><a href="index.php">HOSTEL-J</a><a href="http://www.thapar.edu" target="_blank" style="font-weight:100"> Thapar University</a></h1>
            <nav id="nav">      <h1 style="font-size:30px "><a href="index.php">HOSTEL-J</a><a href="login.php">Sign In</a><a href="http://www.thapar.edu" target="_blank" style="font-weight:100"> Thapar University</a></h1>

            </nav>
        </header>

        <!-- Main -->
        <section id="main" class="container small" style="padding: 0">
            <header style="padding: 0">
                <h2 style="padding: 0">Contact Us</h2>
                <p style="padding: 0"><?php
   if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
						//echo $_COOKIE['count'];
						$c = $_COOKIE['count'];
						$c= $c+1;
//echo $c; 
						setcookie('coun', $c , time() + (3600), "/");
echo  $_COOKIE['coun'] ;
						if($c > 2){ ?>
							<script type="text/javascript">
							  spam_alert();
							</script>
                            <?php
							
						}
                        $name = $_POST['name'];
                        echo "Hi $name, we have received your message";
                    } else
                        echo "Tell us what you think about our little operation. ";

                    ?></p>
            </header>
            <div class="box">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row uniform half collapse-at-2">
                        <div class="6u">
                            <input type="text" name="name" id="name" value="" placeholder="Name" required title="Enter your name"/>
                        </div>
                        <div class="6u">
                            <input type="email" name="email" id="email" value="" placeholder="Email" required title="Enter your valid email id"/>
                        </div>
                    </div>

                    <div class="row uniform half">
                        <div class="12u">
                            <textarea name="message" id="message" placeholder="Enter your message" rows="6" required title="Enter your message/feedback"></textarea>
                        </div>
                    </div>
                    <div class="row uniform">
                        <div class="12u">
                            <ul class="actions align-center">
                                <li><input type="submit" value="Send Message" /></li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <?php
        if($count >2){
		echo "hello";
		
	} ?>

        <?php
        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {

            $stmt = $mysqli->prepare('insert into contact(name, email, message) values (?,?,?)');
            $stmt->bind_param('sss', $name, $email, $msg);
            $name = string_validate($_POST['name']);
            $email = string_validate($_POST['email']);
            $msg = string_validate($_POST['message']);
            $stmt->execute();
            $to=$_POST['email'];
            $subject="Regarding your Feedback/Request at Hostel-J online portal";
            $message="We have received your feedback/request. Its being processed and we will get back to you as soon as possible.";
            $headers="From:Hostel-J<developer@onlinehostelj.in>";
            mail($to,$subject,$message,$headers);
            $to="developer@onlinehostelj.in";
            $subject="New request or feedback";
            $message="Name = ".$_POST['name']." Email = ".$_POST['email']." Message = ".$_POST['message'];
            $headers="From:".$_POST['name']."<".$_POST['email'].">";
            mail($to,$subject,$message,$headers);
            
        }
        ?>

        <!-- Footer -->
        <?php require_once "footer.php"; ?>
    </body>
</html>