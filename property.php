<?php
    include "includes/functions.php";
	GrantAuthenticated();
	$active = array("Not Active", "Active");
	if(isset($_GET['a']) && $_GET['a'] != "") {
		$id = $_GET['id'];
		$a = $_GET['a'];
		if($a == 'delete'){
			$n = DBQuery("DELETE FROM properties WHERE id=?",array($id));
			if($n > 0)
				$_SESSION['appSMsg'] = "Record deleted Successfully.";
			else
				$_SESSION['appMsg'] = "Record was NOT deleted Successfully.";
		}elseif($a == 'activate'){
			$state = $_GET['state'];
			$val = $state == 1 ? 0 : 1;
			$data['active'] = $val;
			$data['id'] = $id;
			$fieldsArray = array("active","id");
			$n = DBUpdate("properties", $fieldsArray, $data, "id");
			if($n > 0)
				$_SESSION['appSMsg'] = "Record Updated Successfully.";
			else
				$_SESSION['appMsg'] = "Failed to Updated Record.";
		}
    }
	if(isset($_POST['roleId']) && isset($_POST['userId'])) {
		$id = $_POST['userId'];
		$val = $_POST['roleId'];
		$data['roleId'] = $val;
		$data['id'] = $id;
		$fieldsArray = array("roleId","id");
		$n = DBUpdate("properties", $fieldsArray, $data, "id");
		if($n > 0)
			$_SESSION['appSMsg'] = "Record Updated Successfully.";
		else
			$_SESSION['appMsg'] = "Failed to Updated Record.";
    }
	$records = DBSelect("SELECT * FROM properties");
	
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
					<h2>Property Management</h2><hr/>
					<div class="w3-container">
						<a href="addproperty.php" class="w3-text-blue w3-hover-text-red w3-btn" style="text-decoration:none"><i class="fa fa-plus"></i> Add Property</a>
						<table class="w3-table-all">
							<thead>
								<th>ACTION</th>
								<th>ID</th>
								<th>TITLE</th>
								<th>PROP. TYPE</th>
								<th>ADDRESS</th>
								<th>DESCRIPTION</th>
								<th>CONTACT</th>
								<th>PRICE</th>
								<th>ACTIVE</th>
								<th>DATE</th>
							</thead>
							<tbody>
								<?php
								$types = array("" => "All Types","1" => "Residential Home","2" => "Office Apartment","3" => "Retail Shop/Store","4" => "Warehouse/Store","5" => "Commercial Properties");
								$ct = 1; foreach($records as $record){
								?>
								<tr>
									<td>
										<a href="property.php?id=<?php echo $record['id']; ?>&a=delete"><i class="w3-text-red fa fa-trash-o"></i></a>
										<a href="property.php?id=<?php echo $record['id']; ?>&a=activate&state=<?php echo $record['active']; ?>"><i class="<?php if($record['active']==1){ echo "w3-text-green "; }else { echo "w3-text-grey "; } ?>fa fa-check"></i></a>
									</td>
									<td><?php echo $ct++; ?></td>
									<td><?php echo $record['title']; ?></td>
									<td><?php echo $types[$record['category']]; ?></td>
									<td><?php echo $record['address']; ?></td>
									<td><?php echo $record['description']; ?></td>
									<td><?php echo $record['contact']; ?></td>
									<td><?php echo $record['amount']; ?></td>
									<td><?php echo $record['active']; ?></td>
									<td><?php echo $record['date']; ?></td>
								</tr>
								<?php
								}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include "includes/footer.php"; ?>