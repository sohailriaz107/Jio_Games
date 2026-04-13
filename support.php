<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days in seconds
session_start(); 
	include("include/connect.php");
    include("include/session.php");
	include("include/functions.php");
	

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Whatsapp Support, Live Support, Telegram Support - <?php echo $site_title;?></title>
    
    <?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>
            
            <div class="container py-4">
                
                <div class="text-center mb-4">
                    <h2 style="font-weight: 800; color: #2b3648; font-size: 24px; margin-bottom: 5px;">Support Center</h2>
                    <p style="color: #64748b; font-size: 14px;">Contact our experts for instant help</p>
                </div>

                <!-- LIVE CHAT CARD -->
                <a href="<?php echo LIVE_CHAT_URL;?>" class="premium-support-card chat">
                    <div class="support-icon-box"><i class="fa fa-comments"></i></div>
                    <div class="support-info">
                        <span class="support-title">Live Chat Support</span>
                        <span class="support-subtitle">Connect with our agents instantly</span>
                    </div>
                    <div class="support-arrow"><i class="fa fa-chevron-right"></i></div>
                </a>

                <!-- WHATSAPP CARDS -->
                <a href="https://wa.me/<?php echo get_SettingValue('PWA_whatsapp1');?>" class="premium-support-card wa">
                    <div class="support-icon-box"><i class="fa fa-whatsapp"></i></div>
                    <div class="support-info">
                        <span class="support-title">WhatsApp Support</span>
                        <span class="support-subtitle">Billing & Fund Addition Issues</span>
                    </div>
                    <div class="support-arrow"><i class="fa fa-chevron-right"></i></div>
                </a>

                <a href="https://wa.me/<?php echo get_SettingValue('PWA_whatsapp2');?>" class="premium-support-card wa">
                    <div class="support-icon-box"><i class="fa fa-whatsapp"></i></div>
                    <div class="support-info">
                        <span class="support-title">WhatsApp Support</span>
                        <span class="support-subtitle">Account & Other Queries</span>
                    </div>
                    <div class="support-arrow"><i class="fa fa-chevron-right"></i></div>
                </a>

                <!-- TELEGRAM CARD -->
                <a href="<?php echo TELEGRAM_URL;?>" class="premium-support-card tg">
                    <div class="support-icon-box"><i class="fa fa-telegram"></i></div>
                    <div class="support-info">
                        <span class="support-title">Telegram Chat</span>
                        <span class="support-subtitle">Highly Secure & Encrypted Chat</span>
                    </div>
                    <div class="support-arrow"><i class="fa fa-chevron-right"></i></div>
                </a>

                <!-- SECURITY NOTICE -->
                <div class="support-notice-banner">
                    <i class="fa fa-shield"></i>
                    <span>Please use <b>Telegram</b> for a highly secure and encrypted chat experience.</span>
                </div>

            </div>
            </div> 
      
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

<?php if(0){?>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/64d1d76acc26a871b02dee5c/1h79r2uj8';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<?php } ?>

</body>

</html>