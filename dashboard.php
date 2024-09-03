<?php
    include "includes/functions.php";
	GrantAuthenticated();
?>
<?php
    include "includes/header.php";
?>
      <!-- main content container start -->
	<div class="w3-row w3-myfont">
		<div class="w3-col l2  w3-theme-d3 w3-bar-block">
			  <?php include "menu.php"; ?>
		</div>
		<!-- Page Content -->
		<div class="w3-col l10">
			<div class="w3-padding">
				<div class="w3-container">
					<h2>Welcome to CPanel</h2><hr/>
					
				</div>
			</div>
		</div>
	</div>
<?php include "includes/footer.php"; ?>