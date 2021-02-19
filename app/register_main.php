<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="generator" content="">
  <title>Register | Media Organiser</title>
  <!-- Bootstrap core CSS -->
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link href="/assets/css/custom.css" rel="stylesheet" crossorigin="anonymous">
  <!-- Custom styles for this template -->
  <link href="/assets/css/floating-labels.css" rel="stylesheet">
</head>
<body>

  <?
if(isset($_POST['create_account'])) {
	//iniitally set 'no errors found'
  	$error_log = "";
  	$form_error = false;
  	//variable posted fields

	//variable posted fields
	$email = clean_data($_POST['email']);
	$password = clean_data($_POST['password']);
	$access = clean_data($_POST['access']);
  $account_type = clean_data($POST['account_type']);

	// //Password Check
	if($password<>"password") {
	  if(preg_match("/^.*(?=.{5,16})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $password) === 0) {
		  $form_error = true;
		  $error_log .= "Password length must be between 5 and 16 characters and contain at least one upper case and one number |";
	  }else{
		  //Set the Password
			$options = [
				'cost' => 12,
				];
			$password = password_hash($password, PASSWORD_BCRYPT, $options);
	  }
	}

	//Duplicate Email Check
	$duplicate_email_details=mysqli_query($dbmo,"SELECT * FROM `accounts` WHERE email='".strtolower($email)."'");
	 $duplicate_email=mysqli_fetch_array($duplicate_email_details);
	 if(!empty($duplicate_email['email'])){
	 	$form_error = true;
	 	$error_log .= "We have found this email address already in our database,<strong>".$duplicate_email['email']."</strong> |";
	 }

	if($form_error==false){
		// All OK Insert record
		$build_query = "INSERT INTO `accounts` set ";
		$build_query .= "account_type='1', ";
		$build_query .= "email='".mysqli_real_escape_string($dbmo,strtolower($email))."', ";
		$build_query .= "password='".$password."', ";
		$build_query .= "access='1', ";
		$build_query .= "create_date='".date("Y-m-d H:i:s")."' ";

		//Execute the Query
		echo $build_query;

		if (mysqli_query($dbmo, $build_query)) {
			$last_id = mysqli_insert_id($dbmo);

			//Activity Log
			mysqli_query($dbmo,"INSERT INTO `activity_log` (date,time,type,info,acc_id) VALUES ('".date("Y-m-d")."','".date("H:i:s")."','Account Editied','Account Created ID: ".$last_id." - ".$email." ".$password."</br> ".$change_log."','".$last_id."')");

			//Forward onto Upload Page
			 header("Location: dashboard");
			 exit();

		}
	}//end form
}//end
?>


<form role="form" class="form-signin" name="register" action="register" method="post">
  <div class="card">
    <div class="card-body">
      <div class="text-center mb-3">
        <?
          //echo $build_query;


      		  if($form_error == true) {
      			 echo "<div class=\"alert alert-solid alert-danger\">";
      			 echo "<strong>Oops..</strong><br />";
      			 $error_debug = explode("|", substr($error_log,0,-1));
      			 $i=1;
      			 foreach($error_debug as $the_error) {
      			  echo "<strong>".$i.".</strong> ".$the_error."<br />";
      			  $i++;
      			 }
      			 echo "</div>";
      		  }
      		  if($form_error == false && !empty($change_log)) {
      			echo "<div class=\"alert alert-solid alert-success\">";
      			echo "<strong>".$change_log."</strong><br />";
      			echo "</div>";
      		  }
      		  ?>
        <br>
        <h5 class="mb-0">Register For An Account</h5>
        <span class="d-block text-muted">Your Credentials</span>
      </div>

<div class="form-label-group">
  <input type="email" class="form-control" name="email" id="email"  required>
  <label for="inputEmail">Email address</label>
</div>

<div class="form-label-group">
  <input type="password" class="form-control" id="password" name="password"  required>
  <label for="inputPassword">Password</label>
</div>


<button name="create_account" class="btn btn-primary btn-block" type="submit">Create Account</button>
</form>
<br>
<a href="login"><button class="btn btn-primary btn-block text-white" type="button">Back To Login</button></a>
<br>
<span class="form-text text-center text-muted">By continuing, you're confirming that you've read our <a href="#">Terms &amp; Conditions</a> and <a href="#">Cookie Policy</a></span>
</div>
</div>
</form>
