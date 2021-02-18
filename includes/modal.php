<?php
$id = clean_data($_GET["id"]);
//echo $id;

if(isset($_POST['save_cat'])) {
//iniitally set 'no errors found'
  $error_log = "";
  $form_error = false;

//variable posted fields
$title = clean_data($_POST['title']);


if($form_error==false){
  //Company name Check
  if(empty($title)) {
    $form_error = true;
    $error_log .= "Title must be completed |";
  }
  //Company brand name Check
  //if(empty($media)) {
    //$form_error = true;
    //$error_log .= "media must be selected |";
  //}
}

if($form_error==false){

  // All OK Insert record
  $build_query = "INSERT INTO `category` set ";
  $build_query .= "title='".mysqli_real_escape_string($dbmo,ucwords(strtolower($title)))."',";
  $build_query .= "acc_id='".$accountDetail['id']."'";
  //Execute the Query
  //echo $build_query;

  mysqli_query($dbmo, $build_query);
  //if (mysqli_query($dbmo, $build_query)) {
  //  $last_id = mysqli_insert_id($dbmo);
    //Activity Log
    mysqli_query($dbmo,"INSERT INTO `activity_log` (date,time,type,info,acc_id) VALUES ('".date("Y-m-d")."','".date("H:i:s")."','Category Added','ID: ".$last_id." - </br> Category Added :','1')");
  // $change_log = "Category Added : ".$last_id."";

  }

}//end


?>


<!-- Modal -->
<div class="modal fade" id="createcatmodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="createcatmodal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createcatmodal">Create A Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form name="save_cat" method="post" >
      <div class="modal-body">
          <div class="form-group">
            <label for="title">Category Title</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="title">
          </div>
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
          <div class="form-group">
            <label for="exampleFormControlSelect1">Select the media you want to use</label>
            <select class="form-control" id="exampleFormControlSelect1">
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="save_cat" id="save_cat" class="btn btn-primary">Save</button>
      </div>
     </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addcatmodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addcatmodal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addcatmodal">Edit A Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="exampleFormControlInput1">Edit Category Title</label>
            <select class="js-example-basic-multiple" name="states[]" multiple="multiple">
              <option value="AL">Alabama</option>
                ...
              <option value="WY">Wyoming</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editcatmodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editcatmodal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editcatmodal">Edit A Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="exampleFormControlInput1">Edit Category Title</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<?php

if(isset($_POST['save_play'])) {
//iniitally set 'no errors found'
  $error_log = "";
  $form_error = false;

//variable posted fields
$title = clean_data($_POST['title']);
$description = clean_data($_POST['description']);


if($form_error==false){
  //Title Check
  if(empty($title)) {
    $form_error = true;
    $error_log .= "Title must be completed |";
  }
  //Description Check
  if(empty($description)) {
    $form_error = true;
    $error_log .= "Description must be selected |";
  }
}

if($form_error==false){

  // All OK Insert record
  $build_query = "INSERT INTO `playlists` set ";
  $build_query .= "title='".mysqli_real_escape_string($dbmo,ucwords(strtolower($title)))."',";
  $build_query .= "description='".mysqli_real_escape_string($dbmo,ucwords(strtolower($description)))."',";
  $build_query .= "acc_id='".$accountDetail['id']."'";
  //Execute the Query
  echo $build_query;

  if (mysqli_query($dbmo, $build_query)) {
    $last_id = mysqli_insert_id($dbmo);
    //Activity Log
    mysqli_query($dbmo,"INSERT INTO `activity_log` (date,time,type,info,acc_id) VALUES ('".date("Y-m-d")."','".date("H:i:s")."','Playlist Added','ID: ".$last_id." - </br> Playlist Added :','.$last_id.')");
   $change_log = "Playlist Added : ".$last_id."";

  }
 }
}//end


?>

<!-- Modal -->
<div class="modal fade" id="createplaylist" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="createplaylist" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createplaylist">Create A Playlist</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="save_play" method="post" >
        <div class="modal-body">
            <div class="form-group">
              <label for="title">Playlist Title</label>
              <input type="text" class="form-control" name="title" id="title" placeholder="title" required>
            </div>
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
                <div class="form-group">
                  <label for="title">Playlist Description</label>
                  <input type="text" class="form-control" name="description" id="description" placeholder="description" required>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="save_play" id="save_play" class="btn btn-primary">Save</button>
        </div>
       </form>
    </div>
  </div>
</div>
