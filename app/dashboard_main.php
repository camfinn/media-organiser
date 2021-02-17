
<?php
checkLoggedin('secure', 'login');
echo "".$accountDetail['id']."";

$medias=mysqli_query($dbmo,"SELECT * FROM `media` WHERE acc_id= ".$accountDetail['id']."");
$media=mysqli_fetch_array($medias);

?>
<!-- start of main -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
  <!-- start of page header -->
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
  </div>
  <!-- end of page header -->
  <!-- start of tab 1 -->

  <!-- start of row -->
  <div class="row">
    <!-- start of col -->
    <div class="col-6">
      <h3 class="mb-3">Recently Played</h3>
    </div>
    <!-- end of col -->
    <!-- start of col -->
    <div class="col-6 text-right">
      <a class="btn btn-primary mb-3 mr-1" href="#carouselExampleIndicators2" role="button" data-slide="prev">
        <i class="fa fa-arrow-left"></i>
      </a>
      <a class="btn btn-primary mb-3 " href="#carouselExampleIndicators2" role="button" data-slide="next">
        <i class="fa fa-arrow-right"></i>
      </a>
    </div>
    <!-- end of col -->

    <!-- start of col -->
    <div class="col-12">
      <!-- start of card carousel -->
      <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
        <!-- start of carousel inner -->
        <div class="carousel-inner">
          <div class="carousel-item active">

            <div class="row">"
            <?
            $medias=mysqli_query($dbmo,"SELECT * FROM `media` WHERE acc_id= ".$accountDetail['id']."");

            $i = 0; //Set a counter to 0
                while ($media = mysqli_fetch_array($medias)) {
                  $i ++; //Add one to the counter...
                  if($i==3){
                    //If $i == 3 then add a row by ending the exisitng row and starting a new one
                    echo "</div>
                          <!-- end of row -->
                          <div class=\"row\">"
                    //Reset $i to 0
                    $i = 0;
                  }
            ?>
              <!-- start of col -->
              <div class="col-md-4">
                <!-- start of card -->
                <div class="card mb-4 box-shadow">
                  <h5 class="card-header">
                    <?php echo $media['title'] ?>
                  </h5>
                  <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap">
                  <!-- start of card body -->
                  <div class="card-body">
                    <p class="card-text"><?php $media['title']?></p>
                    <div class="d-flex justify-content-between float-right">
                      <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-white bg-primary"><a href="details" class="text-white">View</a></button>
                      </div>
                    </div>
                  </div>
                  <!-- end of card body -->
                </div>
                <!-- end of card -->
              </div>
              <!-- end of col -->
              <?
            }?>
            </div>
            <!-- end of row -->
          </div>
          <!-- end of carousel-->
</main>
<!-- end of main -->
