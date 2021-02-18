<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="generator" content="">
  <title>Login | Media Organiser</title>
  <!-- Bootstrap core CSS -->
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link href="/assets/css/custom.css" rel="stylesheet" crossorigin="anonymous">
  <!-- Custom styles for this template -->
  <link href="/assets/css/floating-labels.css" rel="stylesheet">
</head>
<body>
<?php

//Submitted Form (NORMAL LOGIN)
if(isset($_POST['login_submit'])) {
	//iniditally set 'no errors found'
	$form_error = false;

	//variable posted fields
	$login_email = clean_data($_POST['login_email']);
	$login_email = mysqli_real_escape_string($dbmo,$login_email);
	$login_password = clean_data($_POST['login_password']);

	//do checks on required fields
	if(empty($login_email) || empty($login_password)) {
		$form_error = true;
		$error_log = "Please enter your email address and password";
	} else if(!empty($login_email) && !empty($login_password)) {

		//If we are here we have passed the initial checks and we have valid data...
		$check_details=mysqli_fetch_array(mysqli_query($dbmo,"SELECT email,password FROM `accounts` WHERE email='".$login_email."'"));

		//Password Check
		if (password_verify($login_password, $check_details['password'])) {
			//Password OK..
			$password_status = 1;
		} else {
			//Password NOT OK..
			$password_status = 0;
			$form_error = true;
			$error_log = "Login details incorrect, please try again.<br /><br />";
		}


		if($check_details >= "1" && $password_status == "1") {
      			//If we have an account and the Password is OK.
      			//Check if OK to access the site.
      			$check_access_details=mysqli_fetch_array(mysqli_query($dbmo,"SELECT * FROM `accounts`  WHERE email='".$login_email."'"));
      			$today = date("Y-m-d");

      			if($check_access_details['expire_date'] <$today){
      				//Has the Company Expired
      				$form_error = true;
      				$error_log .= "Subscription has expired<br />";
      			}
			   }
			}

	//after checks, update the account and log them in.
  	if($form_error == false) {

		//Pickup account details
		$accountDetails=mysqli_query($dbmo,"SELECT * FROM `accounts` WHERE email='".$login_email."'");
		$accountDetail=mysqli_fetch_array($accountDetails);

    //Set SESSION
    $_SESSION['loggedin'] = true;
    $_SESSION['account_id'] = $accountDetail['id'];
    $_SESSION['account_type'] = $accountDetail['account_type'];

		//Take to 'Account' once written to the activity log
		//mysqli_query($dbppn,"INSERT INTO `activity_log` (date,time,type,info,acc_id) VALUES ('".date("Y-m-d")."','".date("H:i:s")."','Login','IP Address: ".$loginip."', '".$accountDetail['id']."')");

			//echo "no url";
			header("Location: /dashboard");
			exit();

  	}
}
?>

<form class="form-signin" role="form" name="login" action="login" method="post" >
  <input type="hidden" name="token" value="<?=substr(md5(time()), 10, 26)?>"/>
  <input type="hidden" name="url" value="<?php if(isset($_GET['url'])) {
echo htmlspecialchars($_GET['url']); } ?>">
 <div class="card">
   <div class="card-body">
  <div class="text-center mb-3">
    <br>
    <h5 class="mb-0">Login to your account</h5>
    <span class="d-block text-muted">Your credentials</span>
  </div>
  <?
  //Here display any error messages that are in the $error_log
  if($form_error == true) {
  echo "<div class=\"validation-invalid-label\">".$error_log."</div>";
  }
  ?>
  <div class="form-group form-group-feedback form-group-feedback-left">
    <input type="email" name="login_email"  maxlength="60"  id="login_email" class="form-control" placeholder="Enter your email" required>
    <div class="form-control-feedback">
      <i class="icon-user text-muted"></i>
    </div>
  </div>

  <div class="form-group form-group-feedback form-group-feedback-left">
    <input type="password" id="login_password" name="login_password" maxlength="16" class="form-control" placeholder="Enter your password" required>
    <div class="form-control-feedback">
      <i class="icon-lock2 text-muted"></i>
    </div>
  </div>

  <div class="form-group d-flex align-items-center">
    <div class="form-check mb-0">
    </div>

    <a href="/password-recovery" class="ml-auto">Forgot password?</a>
  </div>
  <br>
  <div class="form-group">
    <button type="submit" name="login_submit" class="btn bg-primary text-white btn-block">Log in <i class="icon-circle-right2 ml-2"></i></button>
    <br>
    <a href="register"><button class="btn btn-primary btn-block text-white" type="button">Register</button></a>
    <br>
    <span class="form-text text-center text-muted">By continuing, you're confirming that you've read our <a href="#">Terms &amp; Conditions</a> and <a href="#">Cookie Policy</a></span>
  </div>
 </div>
</div>
</form>
