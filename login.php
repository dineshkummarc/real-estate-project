<?php
    include "includes/functions.php";
	if(isset($_POST['username']) && isset($_POST['password'])){
		$user = isset($_POST['username']) ? trim($_POST['username']) : "";
		$pass = isset($_POST['password']) ? trim($_POST['password']) : "";
		$p = isset($_POST['p']) ? trim($_POST['p']) : "";
		if(!$user || !$pass) {
			$_SESSION['appMsg'] = "Both User Name and Password are required.";
		}
		else {
			$db = OpenDBConnection();
			$table = $p == "o" ? "users" : "applicantprofiles";
			$row = DBSelectOne("SELECT * FROM $table WHERE username=? AND password = ?", array($user,$pass));
			if($row) {
				unset($row['password']);
				if($row['roleId']!= 1 && $row['isactive'] != 1){
					$_SESSION['appMsg'] = "Sorry! Your account is NOT active. Contact the Management.";
				}else{
					$_SESSION['user'] = $row;
					CloseDBConnection($db);
					RedirectTo("welcome.php");
				}
			}
			else
				$_SESSION['appMsg'] = "Invalid User Name or Password!";
			
				CloseDBConnection($db);
		}
	}
?>
<?php
    include "includes/header.php";
?>
      <!-- main content container start -->
      <div class="w3-row" style="min-height:34em">
		<div class="w3-display-container">
			<img src="<?php echo $imageDir; ?>/bg.jpg" style="width:100%;height:inherit" />
			<div class="w3-container w3-white w3-display-topmiddle w3-round w3-card-8" style="width:80%;margin-top:80px">
				<h2 class="w3-center w3-theme-l5">Login</h2><hr />
				<div class="w3-row w3-padding" style="margin : 0 auto">
					<div class="w3-quarter">&nbsp;</div>
					<div class="w3-half">
						<div class="w3-border">
							<div class="w3-container w3-theme-d3">
								<h2>Login Form</h2>
							</div>
							<form class="w3-container" method="POST">
								<div class="w3-section">
								<label>Username</label>
								<input name="username" class="w3-input" type="text">
								<input name="p" class="w3-input" type="hidden" value="<?php echo isset($_GET["p"]) ? $_GET["p"] : ""; ?>">
								</div>  
								<div class="w3-section">
									<label>Password</label>
									<input name="password" class="w3-input" type="password">
								</div>  
								<div class="w3-section">
									<button class="w3-btn w3-theme-d5 w3-round">Login</button>
								</div>
							</form>
						</div>
					</div>
					<div class="w3-quarter">&nbsp;</div>
				</div>
			</div>
		</div>
	  </div><!-- main content container ends -->
<?php include "includes/footer.php"; ?>