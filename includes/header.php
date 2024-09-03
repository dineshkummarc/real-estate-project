<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Real Estate Management System</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo $cssDir; ?>/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $cssDir; ?>/4/w3.css" />
    <link rel="stylesheet" href="<?php echo $cssDir; ?>/theme/w3-theme.css">
	<style>
		.w3-myfont {
			font-family: sans-serif;
		}
	</style>
	<script type="application/javascript">
        function doPost(form) {
			console.log(form);
			document.getElementById(form).submit();
        }
    </script>
</head>

<body>
    <header class="w3-card-4 w3-theme-dark">
      <div class="w3-row w3-padding-8 w3-xlarge">
			<div class="w3-col l2">
				<img src="<?php echo $imageDir; ?>/newlogo.jpg" height="80" width="80" />
			</div>
			<div class="w3-col l6">
				<div class="w3-margin-0 w3-wide w3-xxlarge w3-myfont" style="text-shadow:1px 1px 0 #444"><?php echo $siteTitle; ?></div>
			</div>
			<div class="w3-col l4">
				
			</div>
      </div>
	  <div class="w3-bar w3-white" style="float:none;width:100%">
		<a href="index.php" class="w3-bar-item w3-button">Home</a>
		<a class="w3-bar-item w3-button" href="adminlogin.php">Admin Login</a>
	</div>
    </header>
    <?php
    //check if there is a global application message to be displayed on the page
    $appMsg = '';
    if(isset($_SESSION['appMsg']) && $_SESSION['appMsg']) {
        $appMsg = $_SESSION['appMsg'];
        unset($_SESSION['appMsg']);
    }
    ?>
    <?php if($appMsg) { ?>
    <div class="w3-panel w3-red w3-margin w3-card-4">
      <span onclick="this.parentElement.style.display='none'" class="w3-btn w3-right">&times;</span>
      <p class="w3-center"><?php echo $appMsg;  ?></p>
    </div>
    <?php } ?>
    <?php
    //check if there is a global application message to be displayed on the page
    $appSMsg = '';
    if(isset($_SESSION['appSMsg']) && $_SESSION['appSMsg']) {
        $appSMsg = $_SESSION['appSMsg'];
        unset($_SESSION['appSMsg']);
    }
    ?>
    <?php if($appSMsg) { ?>
    <div class="w3-panel w3-green w3-margin w3-card-4">
      <span onclick="this.parentElement.style.display='none'" class="w3-btn w3-right">&times;</span>
      <p class="w3-center"><?php echo $appSMsg;  ?></p>
    </div>
    <?php } ?>
    