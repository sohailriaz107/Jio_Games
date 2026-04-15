<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days in seconds
session_start(); 
	include("include/connect.php");
	include("include/functions.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Privacy Policy - <?php echo $site_title; ?></title>
    
    <?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>
            
            
            <div class="container">  
            <div class="card tbmr-40">
                
                <div class=" tb-10">
                    <h3>Privacy Policy</h3>
                    <p>Welcome to RATAN777! We value your privacy and are committed to protecting your personal information. This Privacy Policy outlines how we collect, use, and safeguard your information when you use our website.</p>

                    <h4>Information We Collect</h4>
                    <ul>
                        <li><strong>Personal Information:</strong> When you register or interact with our website, we may collect personal details such as your name, email address, and phone number.</li>
                        <li><strong>Usage Data:</strong> We collect data about your interactions with our website, including pages visited, game activities, and session duration.</li>
                    </ul>

                    <h4>How We Use Your Information</h4>
                    <ul>
                        <li>To provide and improve our services.</li>
                        <li>To process transactions and manage user accounts.</li>
                        <li>To send promotional communications (you can opt-out at any time).</li>
                        <li>To comply with legal obligations.</li>
                    </ul>

                    <h4>Sharing of Information</h4>
                    <p>We do not sell your personal information to third parties. However, we may share information with trusted partners to improve our services or when required by law.</p>

                    <h4>Data Security</h4>
                    <p>We use appropriate technical and organizational measures to protect your information from unauthorized access, loss, or misuse.</p>

                    <h4>Your Rights</h4>
                    <p>You have the right to access, update, or delete your personal information. Contact us at support@jiogames.app to exercise these rights.</p>

                    <h4>Cookies</h4>
                    <p>We use cookies to enhance your experience on our website. You can manage your cookie preferences in your browser settings.</p>

                    <h4>Contact Us</h4>
                    <p>If you have any questions or concerns about our Privacy Policy, please contact us at support@jiogames.app.</p>


                    <br><br><br><br>
                </div>

            </div>
            </div>
            
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>
