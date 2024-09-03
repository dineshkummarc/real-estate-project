<?php
    include "includes/functions.php";
	GrantAuthenticated();
	if(isset($_POST['submit'])) {
		unset($_POST['submit']);
		$fieldsArray = array("fullname", "email", "phone", "username", "password");
		$n = DBInsert("users", $fieldsArray, $_POST);
		if($n > 0)
			$_SESSION['appSMsg'] = "Successful...";
		else
			$_SESSION['appMsg'] = "Error...";
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
					<h2>Add New User</h2><hr/>
					<form method="post" style="width:60%;margin:0 auto">
						<div class="w3-row">
							<label>Full Name</label>
							<input type="text" name="fullname" class="w3-input" />
						</div>
						<div class="w3-row">
							<label>Email</label>
							<input type="email" name="email" class="w3-input" />
						</div>
						<div class="w3-row">
							<label>Phone</label>
							<input type="number" name="phone" class="w3-input" />
						</div>
						<div class="w3-row">
							<label>Username</label>
							<input type="text" name="username" class="w3-input" />
						</div>
						<div class="w3-row">
							<label>Password</label>
							<input type="password" name="password" class="w3-input" />
						</div>
						<div class="w3-row w3-margin-top">
							<button name="submit" class="w3-btn w3-round w3-theme-d3">Add User</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php include "includes/footer.php"; ?>