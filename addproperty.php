<?php
    include "includes/functions.php";
	GrantAuthenticated();
	if(isset($_POST['submit'])) {
		if(isset($_FILES['image'])){
			$temp = explode(".", $_FILES["image"]["name"]);
			$ext = end($temp);
			if($ext == 'jpg'){
				$filename = "property/".time().'.'.$ext;
				if(move_uploaded_file($_FILES["image"]["tmp_name"],$filename)){
					$url = $filename;
					unset($_POST['submit']);
					$_POST['imageUrl'] = $url;
					$fieldsArray = array("title", "category", "address", "description", "contact", "amount", "active", "imageUrl");
					$n = DBInsert("properties", $fieldsArray, $_POST);
					if($n > 0)
						$_SESSION['appSMsg'] = "Successful...";
					else
						$_SESSION['appMsg'] = "Error...";
				}
			}else{
				$_SESSION['appMsg'] = "Ensure that property image is a jpg File...";
			}
		}
    }
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
					<h2>Add New Property Information</h2><hr/>
					<form method="post" style="width:60%;margin:0 auto" enctype="multipart/form-data">
						<div class="w3-row">
							<label>Title</label>
							<input type="text" name="title" class="w3-input" />
						</div>
						<div class="w3-row">
							<label>Property Types</label>
							<select class="w3-select" name="category">
								<option></option>
								<?php CreateList(array("" => "All Types","1" => "Residential Home","2" => "Office Apartment","3" => "Retail Shop/Store","4" => "Warehouse/Store","5" => "Commercial Properties")); ?>
							</select>
						</div>
						<div class="w3-row">
							<label>Address</label>
							<input type="text" name="address" class="w3-input" />
						</div>
						<div class="w3-row">
							<label>Description</label>
							<textarea class="w3-select" name="description"></textarea>
						</div>
						<div class="w3-row">
							<label>Contact Agent Phone <span class="w3-tiny w3-text-red">if any</span></label>
							<input type="number" name="contact" class="w3-input" />
						</div>
						<div class="w3-row">
							<label>Price</label>
							<input type="number" name="amount" class="w3-input" />
						</div>
						<div class="w3-row">
							<label>Active</label>
							<select class="w3-select" name="active">
								<option></option>
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</div>
						<div class="w3-row">
							<label>Property Image (jpg)</label>
							<input type="file" name="image" class="w3-input" />
						</div>
						<div class="w3-row w3-margin-top">
							<button name="submit" class="w3-btn w3-round w3-theme-d3">Add Property</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php include "includes/footer.php"; ?>