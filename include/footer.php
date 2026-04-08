<br><br><br>
<div id="footer-bar" class="footer-bar-1">
<a href="<?php echo SITEURL;?>" class="active-nav"><i class="fa fa-home"></i><span>Home</span></a>
<a href="my-history.php"><i class="fa fa-list"></i><span>History</span></a>
<a href="my-profile.php"><i class="fa fa-user"></i><span>Profile</span></a>
<a href="transaction-history.php"><i class="fa fa-list-alt"></i><span>Passbook</span></a>
<a href="bidding-history.php"><i class="fa fa-history"></i><span>My Bids</span></a>
</div>

<?php if(0){?>
<div class="overlay"></div>
<div id="loading-bg"></div>
<div id="mloader" class="lds-ripple"><div></div><div></div></div>
<?php } ?>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="assets/js/jquery-3.3.1.slim.min.js"></script>
    <!-- Popper.JS -->
    <script src="assets/js/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.min.js"></script>
    
    
    <script type="text/javascript">
    
    <?php if(0){?>
    $(function() {
  $('#loading-bg').hide();
  $('#mloader').hide();

  $(window).on('beforeunload', function() {
    $('#loading-bg').show();
    $('#mloader').show();
  });
});
<?php } ?>

    var grantotal = 0;
    function resetjsvar(){
        grantotal = 0;
    }
        $(document).ready(function () {
			
			$('.addFundamtbox').on('click', function () {
                var addFund_amount = $(this).attr('data');
                $('#add_fund_amount').val(addFund_amount);
                
            });
			
			
           
            $('.bidamtbox').on('click', function () {
                var bid_amount = $(this).attr('data');
                var bid_amount_id = $(this).attr('id');
                $('.bidamtbox').removeClass("active");
                $(this).addClass("active");
                $('#selected_amount').val(bid_amount);
                
            });
            
            $('.pointinputbox').on('click', function () {
                
                var selected_amount = $('#selected_amount').val();
                
                if(selected_amount == ''){
                    alert('Please Select Amount');
                }else{
                    var exist_amount = $(this).val();
                    
                    if(exist_amount == ''){
                        exist_amount=0;
                    }
                    var total = parseInt(exist_amount) + parseInt(selected_amount);
                    $(this).val(total);
                    grantotal += parseInt(selected_amount);
                    $('#total_point2').html(grantotal);
                    $('#total_point').val(grantotal);
                }
            });
            
            
            
            
            $('.pointinputbox').bind('copy paste cut',function(e) {
              e.preventDefault();
            });
            
            

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
            
            $('#dismiss, .overlay').on('click', function () {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });
            
            
        });
        
        
        <?php 
        if(isset($_GET['bidplacedsuccessfully'])){ ?>
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Bid Placed Successfully',
              showConfirmButton: false,
              timer: 1000
            })
       <?php }?>
       
       <?php 
        if(isset($_GET['invalid_date'])){ ?>
            Swal.fire({
              position: 'top-end',
              icon: 'error',
              title: 'Invalid Date',
              showConfirmButton: false,
              timer: 3000
            })
       <?php }?>
       
       <?php 
        if(isset($_GET['bidfailed'])){ ?>
            Swal.fire({
              position: 'top-end',
              icon: 'error',
              title: 'Something Went Wrong, Try Again',
              showConfirmButton: false,
              timer: 3000
            })
       <?php }?>
       
       <?php 
        if(isset($_GET['insufficientbalance'])){ ?>
            Swal.fire({
              position: 'top',
              icon: 'error',
              title: 'Insufficient Balance',
              showConfirmButton: true,
              timer: 3000
            })
       <?php }?>
       
       
       <?php 
        if(isset($_GET['detailupdated'])){ ?>
            Swal.fire({
              position: 'top',
              icon: 'success',
              title: 'Detail Updated',
              showConfirmButton: false,
              timer: 1000
            })
       <?php }?>
       
       <?php 
        if(isset($_GET['invalidrequest'])){ ?>
            Swal.fire({
              position: 'top',
              icon: 'error',
              title: 'Invalid Request',
              showConfirmButton: true,
              timer: 3000
            })
       <?php }?>
       
       <?php 
        if(isset($_GET['notupdated'])){ ?>
            Swal.fire({
              position: 'top',
              icon: 'error',
              title: 'Sorry, Data Not Updated.',
              showConfirmButton: true,
              timer: 3000
            })
       <?php }?>
       
       
</script>
<?php if(0){?>
<script>
if ('serviceWorker' in navigator) {
    console.log("Will the service worker register?");
    navigator.serviceWorker.register('service-worker.js')
        .then(function(reg) {
            console.log("Yes, it did.");
        }).catch(function(err) {
            console.log("No it didn't. This happened:", err)
        });
}
 
</script>

<?php } ?>