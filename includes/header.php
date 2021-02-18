<?php
if($_SESSION['loggedin'] == true){
	$today = date("Y-m-d");
	$accountDetails=mysqli_query($dbmo,"SELECT * FROM `accounts` WHERE id='".$_SESSION['account_id']."'");
	$check_details=mysqli_num_rows($accountDetails);
	 if($check_details==0){
		header("Location: logout");
	 	exit();
	 }
	$accountDetail=mysqli_fetch_array($accountDetails);
}
 ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Media Organiser | Dashboard</title>

  <!-- Bootstrap core CSS -->
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/dropzone.min.css" rel="stylesheet">
  <link href="/assets/css/dropzone.css" rel="stylesheet">
  <link href="/assets/css/basic.min.css" rel="stylesheet">
  <link href="/assets/css/basic.css" rel="stylesheet">
	<!-- <link href="/assets/css/datatables.css" rel="stylesheet"> -->
  <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
  <link href="/assets/css/all.css" rel="stylesheet">
  <link href="/assets/css/fontawesome.css" rel="stylesheet">
<link href="/assets/css/brands.css" rel="stylesheet">
<link href="/assets/css/solid.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="dashboard">Media Organiser</a>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="login">Sign out</a>
    </li>
  </ul>
</nav>
