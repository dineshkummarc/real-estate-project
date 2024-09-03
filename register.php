<?php
    include "includes/functions.php";
	$data = array();
	$data["fullname"] = isset($_POST["fullname"]) ? $_POST["fullname"] : "";
	$data["email"] = isset($_POST["email"]) ? $_POST["email"] : "";
	$data["phone"] = isset($_POST["phone"]) ? $_POST["phone"] : "";
	$data["username"] = isset($_POST["username"]) ? $_POST["username"] : "";
	$data["password"] = isset($_POST["password"]) ? $_POST["password"] : "";
	$data["gender"] = isset($_POST["gender"]) ? $_POST["gender"] : "";
	$data["maritalstatus"] = isset($_POST["maritalstatus"]) ? $_POST["maritalstatus"] : "";
	$data["dob"] = isset($_POST["dob"]) ? $_POST["dob"] : "";
	$data["lga"] = isset($_POST["lga"]) ? $_POST["lga"] : "";
	$data["state"] = isset($_POST["state"]) ? $_POST["state"] : "";
	$data["nationality"] = isset($_POST["nationality"]) ? $_POST["nationality"] : "";
	$data["permaddress"] = isset($_POST["permaddress"]) ? $_POST["permaddress"] : "";
	$data["postaladdress"] = isset($_POST["postaladdress"]) ? $_POST["postaladdress"] : "";
	$data["highestqualification"] = isset($_POST["highestqualification"]) ? $_POST["highestqualification"] : "";
	$data["specialization"] = isset($_POST["specialization"]) ? $_POST["specialization"] : "";
	if(isset($_POST['submit'])) {
		if(isset($_POST['p']) && $_POST['p'] == "o") {
			if($data["fullname"] == "" || $data["email"] == "" || $data["phone"] == "" || $data["username"] == "" || $data["password"] == "") {
				$_SESSION['appMsg'] = "Empty field detected, all fields are required.";
			}else{
				$fieldsArray = array("fullname","email","phone","username","password");
				$n = DBInsert("users", $fieldsArray, $data);
				if($n > 0)
					$_SESSION['appSMsg'] = "Record added Successfully.";
				else
					$_SESSION['appMsg'] = "Record was NOT added Successfully.";
			}
		}elseif(isset($_POST['p']) && $_POST['p'] == "c"){
			if($data["fullname"] == "" || $data["email"] == "" || $data["phone"] == "" || $data["username"] == "" || $data["password"] == "" || $data["gender"] == "" || $data["maritalstatus"] == "" || $data["dob"] == "" || $data["lga"] == "" || $data["state"] == "" || $data["nationality"] == "" || $data["permaddress"] == "" || $data["postaladdress"] == "" || $data["highestqualification"] == "" || $data["specialization"] == "") {
				$_SESSION['appMsg'] = "Empty field detected, all fields are required.";
			}else{
				$fieldsArray = array("fullname","email","phone","username","password","gender","maritalstatus","dob","lga","state","nationality","permaddress","postaladdress","highestqualification","specialization");
				$n = DBInsert("applicantprofiles", $fieldsArray, $data);
				if($n > 0)
					$_SESSION['appSMsg'] = "Record added Successfully.";
				else
					$_SESSION['appMsg'] = "Record was NOT added Successfully.";
			}
		}
    }
?>
<?php
    include "includes/header.php";
?>
      <!-- main content container start -->
      <div class="w3-row">
		<div class="w3-container" style="min-height:30em">
			<div class="w3-container w3-white w3-round w3-card-8" style="width:100%;margin-top:80px">
				<h2 class="w3-center w3-theme-l5">Create an Account - <?php echo isset($_GET['p']) && $_GET['p']=='c' ? "Job Seekers" : "Organizations" ?></h2><hr />
				<div class="w3-row w3-padding" style="margin : 0 auto">
					<div class="w3-quarter">&nbsp;</div>
					<div class="w3-half">
						<div class="w3-border">
							<div class="w3-container w3-theme-d3">
								<h2>Registration Form</h2>
							</div>
							<?php if(isset($_GET["p"]) && $_GET["p"] == "o"){ ?>
							<form class="w3-container" method="POST">
								<div class="w3-section">
									<label>Fullname</label>
									<input name="fullname" class="w3-input" type="text">
									<input name="p" class="w3-input" value="<?php echo isset($_GET['p']) ? $_GET['p'] : ""; ?>" type="hidden">
								</div>  
								<div class="w3-section">
									<label>Email</label>
									<input name="email" class="w3-input" type="email">
								</div>  
								<div class="w3-section">
									<label>Phone</label>
									<input name="phone" class="w3-input" type="number">
								</div>  
								<div class="w3-section">
									<label>Username</label>
									<input name="username" class="w3-input" type="text">
								</div>  
								<div class="w3-section">
									<label>Password</label>
									<input name="password" class="w3-input" type="password">
								</div>  
								<div class="w3-section">
									<input type="submit" value="Register" name="submit" class="w3-btn w3-theme-d5 w3-round" />
								</div>
							</form>
							<?php } ?>
							<?php if(isset($_GET["p"]) && $_GET["p"] == "c"){ ?>
							<form class="w3-container" method="POST">
								<div class="w3-section">
									<label>Fullname</label>
									<input name="fullname" class="w3-input" type="text">
									<input name="p" class="w3-input" value="<?php echo isset($_GET['p']) ? $_GET['p'] : ""; ?>" type="hidden">
								</div>  
								<div class="w3-section">
									<label>Email</label>
									<input name="email" class="w3-input" type="email">
								</div>  
								<div class="w3-section">
									<label>Phone</label>
									<input name="phone" class="w3-input" type="number">
								</div>  
								<div class="w3-section">
									<label>Gender</label>
									<select class="w3-select" name="gender">
										<option></option>
										<option value="M" <?php echo (isset($data['gender']) && $data['gender'] == 'M') ? "selected" : ""; ?>>Male</option>
										<option value="F" <?php echo (isset($data['gender']) && $data['gender'] == 'F') ? "selected" : ""; ?>>Female</option>
									</select>
								</div>  
								<div class="w3-section">
									<label>Marital Status</label>
									<select class="w3-select" name="maritalstatus">
										<option></option>
										<?php CreateList(array('S'=>'Single','M'=>'Married','D'=>'Divorced','W'=>'Widowed','P'=>'Separated'),$data['maritalstatus']); ?>
									</select>
								</div>  
								<div class="w3-section">
									<label>Date of Birth</label>
									<input name="dob" class="w3-input" type="date">
								</div>    
								<div class="w3-section">
									<label>LGA</label>
									<input name="lga" class="w3-input" type="text">
								</div>   
								<div class="w3-section">
									<label>State</label>
									<input name="state" class="w3-input" type="text">
								</div>   
								<div class="w3-section">
									<label>Nationality</label>
									<input name="nationality" class="w3-input" type="text">
								</div>     
								<div class="w3-section">
									<label>Permanent Home Address</label>
									<input name="permaddress" class="w3-input" type="text">
								</div>    
								<div class="w3-section">
									<label>Postal Address</label>
									<input name="postaladdress" class="w3-input" type="text">
								</div>     
								<div class="w3-section">
									<label>Highest Qualification</label>
									<input name="highestqualification" class="w3-input" type="text">
								</div>       
								<div class="w3-section">
									<label>Area of Specialization</label>
									<input name="specialization" class="w3-input" type="text">
								</div>  
								<div class="w3-section">
									<label>Username</label>
									<input name="username" class="w3-input" type="text">
								</div>  
								<div class="w3-section">
									<label>Password</label>
									<input name="password" class="w3-input" type="password">
								</div>  
								<div class="w3-section">
									<input type="submit" value="Register" name="submit" class="w3-btn w3-theme-d5 w3-round" />
								</div>
							</form>
							<?php } ?>
						</div>
					</div>
					<div class="w3-quarter">&nbsp;</div>
				</div>
			</div>
		</div>
	  </div><!-- main content container ends -->
<?php include "includes/footer.php"; ?>