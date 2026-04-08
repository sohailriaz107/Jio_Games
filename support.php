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
            
            <div class="container" > 
            <div class="tb-10">
                
                <div class="row game-list-inner">
                                <div class="col-12">
                                  <a href="<?php echo LIVE_CHAT_URL;?>" class="mplist" ><i class="fa fa-comments"></i> Live Chat</a>
                                </div>
                </div>
				
                
                <div class="row game-list-inner">
                                <div class="col-12">
                                  <a href="https://wa.me/<?php echo get_SettingValue('PWA_whatsapp1');?>" class="mplist" ><i class="fa fa-whatsapp"></i> Whatsapp Chat (Add Fund)</a>
                                </div>
                </div>
				
				<div class="row game-list-inner">
                                <div class="col-12">
                                  <a href="https://wa.me/<?php echo get_SettingValue('PWA_whatsapp2');?>" class="mplist" ><i class="fa fa-whatsapp"></i> Whatsapp Chat (Other Issues)</a>
                                </div>
                </div>
				
				<div class="row game-list-inner">
                                <div class="col-12">
                                  <a href="<?php echo TELEGRAM_URL;?>" class="mplist" ><i class="fa fa-telegram"></i> Telegram Chat</a>
                                </div>
                </div>
                        
            </div>
			
			<div class="tbmar-40 text-center">
                    <span>Please use <b>Telegram</b> for a secure and safe chat experience.  </span>

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