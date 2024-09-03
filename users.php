<?php
    include "includes/functions.php";
	GrantAuthenticated();
	$active = array("Not Active", "Active");
	if(isset($_GET['a']) && $_GET['a'] != "") {
		$id = $_GET['id'];
		$a = $_GET['a'];
		if($a == 'delete'){
			$n = DBQuery("DELETE FROM users WHERE id=?",array($id));
			if($n > 0)
				$suc = "Record deleted Successfully.";
			else
				$err = "Record was NOT deleted Successfully.";
		}elseif($a == 'activate'){
			$state = $_GET['state'];
			$val = $state == 1 ? 0 : 1;
			$data['isactive'] = $val;
			$data['id'] = $id;
			$fieldsArray = array("isactive","id");
			$n = DBUpdate("users", $fieldsArray, $data, "id");
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
		$n = DBUpdate("users", $fieldsArray, $data, "id");
		if($n > 0)
			$_SESSION['appSMsg'] = "Record Updated Successfully.";
		else
			$_SESSION['appMsg'] = "Failed to Updated Record.";
    }
	$records = DBSelect("SELECT * FROM users");
	
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
					<h2>Users Management</h2><hr/>
					<div class="w3-container">
						<a href="adduser.php" class="w3-text-blue w3-hover-text-red w3-btn" style="text-decoration:none"><i class="fa fa-plus"></i> Add User</a>
						<table class="w3-table-all">
							<thead>
								<th>ACTION</th>
								<th>ID</th>
								<th>FULLNAME</th>
								<th>EMAIL</th>
								<th>PHONE</th>
								<th>USERNAME</th>
								<th>PASSWORD</th>
							</thead>
							<tbody>
								<?php $ct = 1; foreach($records as $record){
								?>
								<tr>
									<td>
										<a href="users.php?id=<?php echo $record['id']; ?>&a=delete"><i class="w3-text-red fa fa-trash-o"></i></a>
									</td>
									<td><?php echo $ct++; ?></td>
									<td><?php echo $record['fullname']; ?></td>
									<td><?php echo $record['email']; ?></td>
									<td><?php echo $record['phone']; ?></td>
									<td><?php echo $record['username']; ?></td>
									<td><?php echo $record['password']; ?></td>
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