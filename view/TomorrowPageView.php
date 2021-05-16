<!doctype html>
<html lang="en">
  <?php include("view/universal/head.php")?>
  <body>
  	<!--Navigation  -->
  	
   <?php include("view/universal/navbar.php")?>    
    
    <!-- Page tittle -->
	<div class="container-fluid sticky-top sticky-offset bg-light">
		<ul class="nav nav-tabs justify-content-center">
        <li class="nav-item">
            <a class="nav-link <?php if($tabName=="Today") echo "active"; else echo "text-muted"?>" href="index.php?controller=MainPage&action=DueToday"><h3>На сегодня</h3></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($tabName=="Tomorrow") echo "active"; else echo "text-muted"?>" href="index.php?controller=TomorrowPage&action=index"><h3>На завтра</h3></a>
          </li>
        </ul>
	</div>
	<!-- Citas para hoy -->
	<div class="container-fluid col-md-10" id="citas_hoy" style="padding-top: 15px;">
    	
	</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="bootstrap/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/popper.min.js" ></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="view/js/TomorrowPage.js?0.1"></script>
  </body>
</html>