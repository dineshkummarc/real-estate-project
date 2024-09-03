<?php
    include "includes/functions.php";
	GrantAuthenticated();
	$data = array();
	$data["fullname"] = isset($_POST["fullname"]) ? $_POST["fullname"] : "";
	$data["email"] = isset($_POST["email"]) ? $_POST["email"] : "";
	$data["phone"] = isset($_POST["phone"]) ? $_POST["phone"] : "";
	$data["username"] = isset($_POST["username"]) ? $_POST["username"] : "";
	$data["password"] = isset($_POST["password"]) ? $_POST["password"] : "";
	if(isset($_POST['submit'])) {
		if($data["fullname"] == "" || $data["email"] == "" || $data["phone"] == "" || $data["username"] == "" || $data["password"] == "") {
            $_SESSION['appMsg'] = "Empty field detected, all fields are required.";
        }else{
			$data["id"] = isset($_SESSION['user']["id"]) ? $_SESSION['user']["id"] : "";
			$fieldsArray = array("fullname","email","phone","username","password");
			$n = DBUpdate("users", $fieldsArray, $data, "id");
			if($n > 0)
				$_SESSION['appSMsg'] = "Record updated Successfully.";
			else
				$_SESSION['appMsg'] = "Record was NOT updated Successfully.";
		}
    }
	$record = DBSelectOne("SELECT * FROM users WHERE id = ?", array($_SESSION['user']['id']));
	
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
					<h2>Update Profile</h2><hr/>
					<div class="w3-row w3-padding" style="margin : 0 auto">
						<div class="w3-quarter">&nbsp;</div>
						<div class="w3-half">
							<div class="w3-border">
								<div class="w3-container w3-theme-d3">
									<h2>Update Profile Form</h2>
								</div>
								<form class="w3-container" method="POST">
									<div class="w3-section">
										<label>Fullname</label>
										<input name="fullname" class="w3-input" type="text" value="<?php echo $record['fullname']; ?>">
									</div>  
									<div class="w3-section">
										<label>Email</label>
										<input name="email" class="w3-input" type="email" value="<?php echo $record['email']; ?>">
									</div>  
									<div class="w3-section">
										<label>Phone</label>
										<input name="phone" class="w3-input" type="number" value="<?php echo $record['phone']; ?>">
									</div>  
									<div class="w3-section">
										<label>Username</label>
										<input name="username" class="w3-input" type="text" value="<?php echo $record['username']; ?>" />
									</div>  
									<div class="w3-section">
										<label>Password</label>
										<input name="password" class="w3-input" type="text" value="<?php echo $record['password']; ?>" />
									</div>  
									<div class="w3-section">
										<input type="submit" value="Update Profile" name="submit" class="w3-btn w3-theme-d5 w3-round" />
									</div>
								</form>
							</div>
						</div>
						<div class="w3-quarter">&nbsp;</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include "includes/footer.php"; ?>