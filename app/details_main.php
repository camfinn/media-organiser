<?
//checkLoggedin('secure', '/login?url='.urlencode($_SERVER['REQUEST_URI']).'');
$id = clean_data($_GET["id"]);
echo $id;

$medias=mysqli_query($dbmo,"SELECT * FROM `media` WHERE id='".$id."'");
$media=mysqli_fetch_array($medias);

  if(isset($_POST['save_details'])) {
	//iniitally set 'no errors found'
  	$error_log = "";
  	$form_error = false;

  //variable posted fields
  $description = clean_data($_POST['description']);
  $title = clean_data($_POST['title']);
	$image = clean_data($_POST['img']);
	$path = clean_data($_POST['path']);
  $type = clean_data($_POST['type']);


	if($form_error==false){
		//Company name Check
		if(empty($title)) {
			$form_error = true;
			$error_log .= "Title must be completed |";
		}
		//Company brand name Check
		if(empty($description)) {
			$form_error = true;
			$error_log .= "Description must be completed |";
		}
	}

	if($form_error==false){

		// All OK Insert record
		$build_query = "INSERT INTO `media` set ";
		$build_query .= "description='".mysqli_real_escape_string($dbmo,ucwords(strtolower($description)))."', ";
		$build_query .= "title='".mysqli_real_escape_string($dbmo,ucwords(strtolower($title)))."', ";
		$build_query .= "image='".mysqli_real_escape_string($dbmo,ucwords(strtolower($image)))."', ";
		$build_query .= "path='".mysqli_real_escape_string($dbmo,strtolower($path))."', ";
		$build_query .= "type='".mysqli_real_escape_string($type,ucwords(strtolower($type)))."', ";
    $build_query .= "date_modified='".date("Y-m-d H:i:s")."',  ";
    $build_query .= "date_added='".date("Y-m-d H:i:s")."' ";
    //Execute the Query
		//echo $build_query;
		if (mysqli_query($dbmo, $build_query)) {
			$last_id = mysqli_insert_id($dbmo);
			//Activity Log
			mysqli_query($dbmo,"INSERT INTO `activity_log` (date,time,type,info,acc_id) VALUES ('".date("Y-m-d")."','".date("H:i:s")."','Media Added','ID: ".$last_id." - </br> Media Added :','1')");
      $change_log = "Media Added : ".$last_id."";

		}

	}//end form
}//end


?>
<!-- start of main -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
  <!-- start of page header -->
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Details</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
     <button class="btn btn-block btn-outline-white bg-danger text-white"><a href="create-details" class="text-white">Delete<i class="fas fa-trash fa-lg ml-2"></i></a></button>
    </div>
  </div>
  <!-- end of page header -->
  <!-- start of tab 1 -->
  <h4>Edit Details</h4>
  <br>
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
<form name="save_details" method="post" >
      <div class="row">
        <!-- start of col -->
        <div class="col-md-6">
          <!-- start of card -->
          <div class="card mb-4 box-shadow">
            <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap">
            <!-- start of card body -->
            <div class="card-body">
              <h6>Add an image by selecting the dropzone below</h6>
              <br>
            </div>
            <!-- end of card body -->
          </div>
          <!-- end of card -->
        </div>
        <!-- end of col -->
        <!-- start of col -->
        <div class="col-md-6">
          <!-- start of card -->
          <div class="card mb-4 box-shadow">
            <!-- start of card body -->
            <div class="card-body">
              <h6>Upload your media</h6>
             <hr>
             <div class="row">
              <div class="col-sm-6">
                 <label for="category" class="form-label">Please drop the media file you wish to upload</label>
               </div>
             </div>
            </div>
            <!-- end of card body -->
          </div>
          <!-- end of card -->
        </div>
        <!-- end of col -->
      </div>
      <!-- end of row -->
      <!-- end of tab 1 -->
      <div class="row">
        <!-- start of col -->
        <div class="col-md-6">
          <!-- start of card -->
          <div class="card mb-4 box-shadow">
            <!-- start of card body -->
            <div class="card-body">
              <h6>Edit the description of the file here</h6>
             <hr>
              <div class="d-flex justify-content-between align-items-center">
                <div class="input-group input-group-lg">
                  <textarea name="description" id="description" rows="3" style="width: 552px;"><? echo $media['description']; ?></textarea>
                </div>
              </div>
              <br>
            </div>
            <!-- end of card body -->
          </div>
          <!-- end of card -->
        </div>
        <!-- end of col -->
        <!-- start of col -->
        <div class="col-md-6">
          <!-- start of card -->
          <div class="card mb-4 box-shadow">
            <!-- start of card body -->
            <div class="card-body">
              <h6>Edit the Title of the file here</h6>
             <hr>
              <div class="d-flex justify-content-between align-items-center">
                <div class="input-group input-group-lg">
                  <input type="text" class="form-control" aria-label="Large" name="title" id="title" value="<? echo $media['title']; ?>">
                </div>
              </div>
              <br>
            </div>
            <!-- end of card body -->
          </div>
          <!-- end of card -->
        </div>
        <!-- end of col -->
      </div>
      <!-- end of row -->
    <button  type="submit" name="save_details" id="save_details"  class="btn btn-block btn-outline-white bg-primary text-white">Save<i class="fas fa-save fa-lg ml-2"></i></button>
    <br>
    <br>
</form>
<!-- end of main -->
