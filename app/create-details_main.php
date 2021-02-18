<?
//checkLoggedin('secure', '/login?url='.urlencode($_SERVER['REQUEST_URI']).'');
$id = clean_data($_GET["id"]);
echo $id;

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
<style>
					.dropzone { padding: 0 !important; cursor: pointer; }
					.dz-default.dz-message::before {
						content: "" !important;
						color: #1976d2 !important;
						font-family: 'Font Awesome 5 Pro' !important;
						font-weight: lighter;
					}
					.dz-details { display: none; }
					.dz-remove {
						position: relative;
						text-transform: uppercase;
						color: #fff !important;
						background-color: #f44336 !important;
						font-weight: 500;
						text-align: center !important;
						border: 1px solid transparent !important;
						padding: .4375rem .875rem !important;
						font-size: .8125rem;
						line-height: 1.5385;
						border-radius: .1875rem !important;
						transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out !important;
						-webkit-appearance: button;
						overflow: visible;
						margin: 0;
						font-family: inherit;
					}
					.dz-remove:hover {
						background-color: #E23E32 !important;
					}
				</style>

<!-- start of main -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
  <!-- start of page header -->
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Details</h1>
  </div>
  <!-- end of page header -->
  <!-- start of tab 1 -->
  <h4>Create Details</h4>
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
            <!-- Single file upload -->
    				<div class="card">
    					<div class="card-header header-elements-inline">
    						<h5 class="card-title">Single file</h5>
    						<div class="header-elements">
    							<div class="list-icons">
    		                		<a class="list-icons-item" data-action="collapse"></a>
    		                		<a class="list-icons-item" data-action="reload"></a>
    		                		<a class="list-icons-item" data-action="remove"></a>
    		                	</div>
    	                	</div>
    					</div>

    					<div class="card-body">
                <div class="dropzone dropzone-single" data-toggle="dropzone" data-dropzone-url="http://">
                  <div class="fallback">
                      <div class="custom-file">
                          <input type="file" class="custom-file-input" id="dropzoneBasicUpload">
                          <label class="custom-file-label" for="dropzoneBasicUpload">Choose file</label>
                      </div>
                  </div>

                  <div class="dz-preview dz-preview-single">
                      <div class="dz-preview-cover">
                          <img class="dz-preview-img" src="..." alt="..." data-dz-thumbnail>
                      </div>
                  </div>
              </div>


    					</div>
    				</div>
  				<!-- /single file upload -->
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
                  <textarea name="description" id="description" rows="3" style="width: 552px;"></textarea>
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
                  <input type="text" class="form-control" aria-label="Large" name="title" id="title">
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
    <button  type="submit" name="save_details" id="save_details"  class="btn btn-block btn-outline-white bg-primary text-white">Save</button>
    <br>
    <br>
</form>
<!-- end of main -->
