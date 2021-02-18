<?php
    include_once("includes/config.php");
    if(!empty($_FILES)){
      $upload_dir = "media/";
      $fileName = $_FILES['file']['name'];
      $uploaded_file = $upload_dir.$fileName;
      $uploaded_file = $upload_dir.$fileName;


        if(move_uploaded_file($_FILES['file']['tmp_name'], $uploaded_file)){
            $mysql_insert = "INSERT INTO media (`image`)VALUES('".$fileName."') where id = '1'";

            echo "$mysql_insert";
            mysqli_query($dbmo, $mysql_insert) or die("database error:".
            mysqli_error($dbmo));
            }
      }
?>
