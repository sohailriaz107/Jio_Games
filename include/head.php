<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="icon" type="image/png" sizes="192x192"  href="assets/icons/196.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="assets/icons/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">

<meta name="apple-mobile-web-app-title" content="Add to Home">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="OnlineMatkaPlay">

<?php if(0){?>
<script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
<script>
  window.OneSignalDeferred = window.OneSignalDeferred || [];
  OneSignalDeferred.push(function(OneSignal) {
    OneSignal.init({
      appId: "a82d0b2b-7489-111111",
    });
  });
</script>
<?php } ?>
<link rel="stylesheet" href="assets/css/style.css?v=2.0">
<style>
 #loading-bg {
          width: 100%;
          height: 100%;
          position: absolute;
          top: 0;
          left: 0;
          background-color: rgba(0, 0, 0, 0.4);
          z-index: 500;
        }
        
        #loading-image {
          position: fixed;
          top: 50%;
          left: 50%;
          margin: -75px;
          z-index: 510;
        }
        
        .lds-ripple {
display: flex;
  align-items: center;
  justify-content: center;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 80px;
  height: 80px;
}

.addFundamtbox {
  text-align: center;
  margin: 0px;
  border: 1px solid beige;
  display: block;
  padding: 5px 5px;
  border-radius: 5px;
  width: 100%;
  cursor: pointer;
}
.addFundamtbox p {
margin: 0px;
  font-weight: 400;
}


.lds-ripple div {
  position: absolute;
  border: 4px solid #000;
  opacity: 1;
  border-radius: 50%;
  animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
}
.lds-ripple div:nth-child(2) {
  animation-delay: -0.5s;
}
@keyframes lds-ripple {
  0% {
    top: 36px;
    left: 36px;
    width: 0;
    height: 0;
    opacity: 0;
  }
  4.9% {
    top: 36px;
    left: 36px;
    width: 0;
    height: 0;
    opacity: 0;
  }
  5% {
    top: 36px;
    left: 36px;
    width: 0;
    height: 0;
    opacity: 1;
  }
  100% {
    top: 0px;
    left: 0px;
    width: 72px;
    height: 72px;
    opacity: 0;
  }
}

.wts-flt-btn {
    position: fixed;
    right: 10px;
    bottom: 100px;
    display: block;
}

.wts-flt-btn a {
    font-size: 25px;
    background: green;
    color: white;
    padding: 8px 14px;
    border-radius: 44px;
}

.wts-flt-btn a {
  font-size: 25px;
  background: green;
  color: white;
  padding: 8px 14px;
  border-radius: 50%; /* Make it a perfect circle */
  display: flex; /* Use flexbox for centering */
  justify-content: center; /* Center horizontally */
  align-items: center; /* Center vertically */
  width: 44px; /* Set the width to the desired size */
  height: 44px; /* Set the height to the desired size */
  text-decoration: none; /* Remove underlines */
}

.wts-flt-btn a:hover {
  background: darkgreen; /* Change color on hover */
}

.hometext p{
padding-bottom: 10px;
line-height: 14px;
font-size: 10px;
text-align: justify;
}


.table-responsive{
overflow: auto;
}
.starline-chart-table{
	width: 100%;
  text-align: center;
  border: 1px solid gray;
  border-collapse: collapse;
  background: white;
  font-size: 12px;
}
.starline-chart-table thead{
background: var(--primary-light);
  color: white;
}

.starline-chart-table td, .starline-chart-table td{
border: 1px solid #515151;
  padding: 0px 3px;
}

.starline-chart-table .f {
  background: var(--primary-light);
  color: white;
}

/* Fix for scrolling notice wrap on mobile */
#scroll-text {
  white-space: nowrap !important;
  display: inline-block !important;
}
</style>