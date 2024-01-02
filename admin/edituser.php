<?php
// check loggin
	include_once("includes/logged.php");
	include_once("includes/conn.php");
	$status = false;
// getting user id 
	if(isset($_GET["user_id"])){
		$user_id = $_GET["user_id"];
		$status = true;
	}else{
		header("Location: 404.php");
	}

// entered updated user info 
	if($_SERVER["REQUEST_METHOD"] === "POST"){
		$userfullname = $_POST["full-name"];
		$username = $_POST["user-name"];
		$email = $_POST["email"];
		if (isset($_POST["activity"]) == "Yes"){
			$activity = "Yes";
		}else{
			$activity = "No";
		}		
		$newpassword = $_POST["newpassword"];
		$userpassword = $_POST["password"];	

// if the user changed his passwored  		
		if($userpassword!="" && $newpassword!="") {
			if($newpassword!= $userpassword) {
				  $sql="SELECT `password` FROM `userstable` WHERE `id`= ?";
				  $count = $conn->prepare($sql);
				  $count->execute([$user_id]);
				  if($count->rowCount() > 0){
						$result = $count->fetch();   
						$hash = $result["password"];
						$verify = password_verify($userpassword, $hash);
						if($verify){
							// echo "Password is correct";
							$newpassword = password_hash($_POST["newpassword"], PASSWORD_DEFAULT);
							try{
								$sql = "UPDATE `userstable` SET `username`= ? ,`fullname`=?,`password`=?,`email`=?,`activity`=?  WHERE id = ?";
								$stmt1 = $conn->prepare($sql);
								$stmt1->execute([$username, $userfullname, $newpassword, $email, $activity, $user_id]);
								echo "Updated Successfully";
							}catch(PDOException $e){
								echo "Connection failed: " . $e->getMessage();
							}
						}else{
							echo"Old password is incorrect. Please try again.";
						}
					}else{
						echo "NOT STRONG PASS";
					}
			}else{
				echo "Old password and new password are the same. Please try again.";
			}
// if the user entered his usual passwored  
		}else if (isset($_POST['password'])) {
				$sql="SELECT `password` FROM `userstable` WHERE `id`= ?";
				$count = $conn->prepare($sql);
				$count->execute([$user_id]);
				if($count->rowCount() > 0){
					$result = $count->fetch();   
					$hash = $result["password"];
					$verify = password_verify($userpassword, $hash);
					if($verify){
						// echo "Password is correct";
						try{
							$sql = "UPDATE `userstable` SET `username`= ? ,`fullname`=?,`email`=?,`activity`=?  WHERE id = ?";
							$stmt1 = $conn->prepare($sql);
							$stmt1->execute([$username, $userfullname, $email, $activity, $user_id]);
							echo "Updated Successfully";
						}catch(PDOException $e){
							echo "Connection failed: " . $e->getMessage();
						}
					}else {
						echo "False Password";
					}
				}else{
					echo "There is more than 1 password to Ur username";
				}
		}else {
			echo "Enter your User Password ";
		}	
	}

// showing logged user info except the password for security
if($status){
	if(isset($_GET["user_id"])){
		$user_id = $_GET["user_id"];
		$status = true;
	}
try{
	$sql = "SELECT * FROM `userstable` WHERE id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$user_id]);
	$result = $stmt->fetch();
	$userfullname = $result["fullname"];
	$username = $result["username"];
	$email = $result["email"];
	$activity = $result["activity"];
	if($activity == "Yes"){
		$activeStr = "checked";
	}else{
		$activeStr = "";
	}

}catch(PDOException $e){
	echo "Connection failed: " . $e->getMessage();
} 
}
	


?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Rent Car Admin | Edit User</title>

	<!-- Bootstrap -->
	<link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	<!-- bootstrap-wysiwyg -->
	<link href="vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
	<!-- Select2 -->
	<link href="vendors/select2/dist/css/select2.min.css" rel="stylesheet">
	<!-- Switchery -->
	<link href="vendors/switchery/dist/switchery.min.css" rel="stylesheet">
	<!-- starrr -->
	<link href="vendors/starrr/dist/starrr.css" rel="stylesheet">
	<!-- bootstrap-daterangepicker -->
	<link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

	<!-- Custom Theme Style -->
	<link href="build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
	<div class="container body">
		<div class="main_container">
	
            <!-- sidebar menu & menu profile quick info & sidebar menu & menu footer buttons & navigation bar     -->
			<?php
			include_once("includes/sidebar.php");
			?>

			<!-- page content -->
			<div class="right_col" role="main">
				<div class="">
					<div class="page-title">
						<div class="title_left">
							<h3>Manage Users</h3>
						</div>

						<div class="title_right">
							<div class="col-md-5 col-sm-5  form-group pull-right top_search">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search for...">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button">Go!</button>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									<h2>Edit User</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
										</li>
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i></a>
											<ul class="dropdown-menu" role="menu">
												<li><a class="dropdown-item" href="#">Settings 1</a>
												</li>
												<li><a class="dropdown-item" href="#">Settings 2</a>
												</li>
											</ul>
										</li>
										<li><a class="close-link"><i class="fa fa-close"></i></a>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>



								<div class="x_content">
									<br />
									<form id="demo-form2" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">

										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Full Name <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="first-name" name="full-name" required="required" value="<?php echo $userfullname ?>" class="form-control ">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="user-name">Username <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="user-name" name="user-name" required="required" value="<?php echo $username ?>" class="form-control">
											</div>
										</div>
										<div class="item form-group">
											<label for="email" class="col-form-label col-md-3 col-sm-3 label-align">Email <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="email" class="form-control" type="email" name="email" value="<?php echo $email ?>" required="required">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align">Active</label>
											<div class="checkbox">
												<label>
													<input type="checkbox" name="activity" <?php echo $activeStr ?> class="flat">
												</label>
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" required="required" for="password">User Password <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="password" id="password" name="password" required="required" class="form-control">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="password">Change Password </label>
											<div class="col-md-6 col-sm-6 ">
												<input type="password" id="password" name="newpassword" class="form-control">
											</div>
										</div>
								
										<div class="ln_solid"></div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
											    <button type="button" class="btn btn-primary" onclick="history.back();">Cancel</button>
												<button type="submit" class="btn btn-success">Update</button>
											</div>
										</div>

									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!-- /page content -->

			<!-- footer content -->
			<footer>
				<div class="pull-right">
					Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
				</div>
				<div class="clearfix"></div>
			</footer>
			<!-- /footer content -->
		</div>
	</div>

	<!-- jQuery -->
	<script src="vendors/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<!-- FastClick -->
	<script src="vendors/fastclick/lib/fastclick.js"></script>
	<!-- NProgress -->
	<script src="vendors/nprogress/nprogress.js"></script>
	<!-- bootstrap-progressbar -->
	<script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
	<!-- iCheck -->
	<script src="vendors/iCheck/icheck.min.js"></script>
	<!-- bootstrap-daterangepicker -->
	<script src="vendors/moment/min/moment.min.js"></script>
	<script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- bootstrap-wysiwyg -->
	<script src="vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
	<script src="vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
	<script src="vendors/google-code-prettify/src/prettify.js"></script>
	<!-- jQuery Tags Input -->
	<script src="vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
	<!-- Switchery -->
	<script src="vendors/switchery/dist/switchery.min.js"></script>
	<!-- Select2 -->
	<script src="vendors/select2/dist/js/select2.full.min.js"></script>
	<!-- Parsley -->
	<script src="vendors/parsleyjs/dist/parsley.min.js"></script>
	<!-- Autosize -->
	<script src="vendors/autosize/dist/autosize.min.js"></script>
	<!-- jQuery autocomplete -->
	<script src="vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
	<!-- starrr -->
	<script src="vendors/starrr/dist/starrr.js"></script>
	<!-- Custom Theme Scripts -->
	<script src="build/js/custom.min.js"></script>

</body></html>
