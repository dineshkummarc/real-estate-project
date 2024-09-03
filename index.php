<?php
    include "includes/functions.php";
?>
<?php
    include "includes/header.php";
?>
      <!-- main content container start -->
      <div class="w3-row" style="min-height:34em">
		<div class="w3-display-container">
			<img src="<?php echo $imageDir; ?>/bg.jpg" style="width:100%;height:inherit" />
			<div class="w3-container w3-white w3-display-topmiddle w3-round w3-card-8" style="width:80%;margin-top:80px">
				<h2 class="w3-center">Search for Property</h2><hr />
				<form action="search.php" method="get">
				<div class="w3-row w3-padding">
					<div class="w3-col l5">
						<label>Property Types</label>
						<select class="w3-select" name="category">
							<option></option>
							<?php CreateList(array("" => "All Types","1" => "Residential Home","2" => "Office Apartment","3" => "Retail Shop/Store","4" => "Warehouse/Store","5" => "Commercial Properties")); ?>
						</select>
					</div>
					<div class="w3-col l5">
						<label>Search Term</label>
						<input name="searchterm" type="text" class="w3-input" placeholder="Enter a search term..." />
					</div>
					<div class="w3-col l12">
						<label style="display:block">&nbsp; &nbsp;</label>
						<button class="w3-btn w3-theme-d5 w3-round w3-margin-left">Search</button>
					</div>
				</div>
				</form>
				<br/>
			</div>
		</div>
	  </div><!-- main content container ends -->
<?php include "includes/footer.php"; ?>