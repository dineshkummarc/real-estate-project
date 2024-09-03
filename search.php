<?php
    include "includes/functions.php";
	$where = "";
	if(isset($_GET['category']) && $_GET['category'] != ""){
		$where .= " category = " . $_GET['category'];
	}
	if(isset($_GET['searchterm']) && $_GET['searchterm'] != ""){
		if($where != "")
			$where .= " OR title LIKE '%" . $_GET['searchterm'] . "%' OR  description LIKE '%" . $_GET['searchterm'] . "%' OR  address LIKE '%" . $_GET['searchterm'] . "%'";
		else
			$where .= " title LIKE '%" . $_GET['searchterm'] . "%' OR  description LIKE '%" . $_GET['searchterm'] . "%' OR  address LIKE '%" . $_GET['searchterm'] . "%'";
	}
	$sql = "SELECT * FROM properties WHERE $where";
	$records = DBSelect($sql);
?>
<?php
    include "includes/header.php";
?>
      <!-- main content container start -->
    <div class="w3-row" style="min-height:34em">
		<div class="w3-quarter w3-padding">
			<form action="search.php" method="get">
			<div class="w3-section">
				<h1>Quick Search</h1>
			</div>
			<div class="w3-section">
				<h3>Categories</h3>
				<select class="w3-select" name="category">
					<option></option>
					<?php CreateList(array("" => "All Types","1" => "Residential Home","2" => "Office Apartment","3" => "Retail Shop/Store","4" => "Warehouse/Store","5" => "Commercial Properties")); ?>
				</select>
			</div>
			<div class="w3-section">
				<h3>Search</h3>
				<input type="text" name="searchterm" class="w3-input" placeholder="Enter a search term..." />
			</div>
			<div class="w3-section">
				<label style="display:block"></label>
				<button class="w3-btn w3-theme-d5 w3-round">Search</button>
			</div>
			</form>
		</div>
		<div class="w3-threequarter">
			<div class="w3-container w3-white w3-round w3-card-8">
				<h2 class="w3-center">Search Results</h2><hr />
				<div class="w3-rowpadding">
					<?php foreach ($records as $record){?>
						<div class="w3-row w3-padding">
							<div class="w3-half"><img src="<?php echo $record['imageUrl']; ?>" style="width:100%;height:200px" /></div>
							<div class="w3-half w3-padding">
								<div class="w3-border w3-padding" style="height:190px;overflow:auto">
									<div class="w3-margin-bottom" style="font-size:12px;font-weight:bold"><?php echo $record['title']; ?> - <?php echo $record['category']; ?></div>
									<div class="w3-margin-bottom" style="font-size:12px;font-weight:bold"><i class="fa fa-map-marker"></i> <?php echo $record['address']; ?></div>
									<div class="w3-margin-bottom" style="font-size:12px;font-weight:bold"><i class="fa fa-phone"></i> <?php echo $record['contact']; ?></div>
									<div class="w3-margin-bottom" style="font-size:12px;font-weight:bold"><i class="fa fa-money"></i> <?php echo $record['amount']; ?></div>
									<div class="w3-margin-bottom" style="font-size:12px;font-weight:bold"><i class="fa fa-info"></i> <?php echo $record['description']; ?></div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	  </div><!-- main content container ends -->
<?php include "includes/footer.php"; ?>