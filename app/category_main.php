<!-- <link href="/assets/css/bootstrap.playlist.css" rel="stylesheet"> -->

<!-- start of main -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
<!-- start of page header -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">My Categories</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
 </div>
</div>
<!-- end of page header -->
<div class="card">
  <div class="card-body">
    <div class="row">
    <div class="col-3">
      <div class="row">
        <div class="col-12"><button class="btn btn-block btn-outline-white bg-primary text-white" data-toggle="modal" data-target="#createcatmodal">Add Category</button></div>
      </div>
      <br>
      <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <?php
          $i=1;
          $search_categories=mysqli_query($dbmo,"SELECT * FROM `category` WHERE acc_id= ".$accountDetail['id']." order by `id` DESC");
          while ($search_category = mysqli_fetch_array($search_categories)) {
            if($i==1){
              //First Record Make Active
              $status = 'active';
              $active_tab = $search_category['id'];
            }
          echo "<a class=\"nav-link $status\" id=\"v-".$search_category['id']."-tab\" data-toggle=\"pill\" href=\"#v-".$search_category['id']."\" role=\"tab\" aria-controls=\"v-".$search_category['id']."\" aria-selected=\"false\">".$search_category['title']."<span class=\"float-right\"><button class=\"btn text-white\" data-toggle=\"modal\" data-target=\"#addcatmodal\"><i class=\"fas fa-plus icon-white ml-2\"></i></button><button class=\"btn text-white\" data-toggle=\"modal\" data-target=\"#editcatmodal\"><i class=\"fas fa-pencil-alt icon-white ml-2\"></i></button><i class=\"far fa-trash-alt ml-2\"></i></span></a>";

          $status = '';
          $i++;
          }
      ?>
      </div>
    </div>

    <div class="col-9">
      <div class="tab-content" id="v-pills-tabContent">
        <?php
        $search_categories=mysqli_query($dbmo,"SELECT * FROM `category` WHERE acc_id= ".$accountDetail['id']." order by `id` DESC");
        while ($search_category = mysqli_fetch_array($search_categories)) {

          if($search_category['id']==$active_tab){
            //First Record Make Active
            $status = 'show active';
          }
          echo"<div class=\"tab-pane fade $status\" id=\"v-".$search_category['id']."\" role=\"tabpanel\" aria-labelledby=\"v-".$search_category['id']."-tab\">

          <!-- Basic initialization -->
          <div class=\"card\">
            <table class=\"table datatable-row-basic\">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Media Title</th>
                  <th>Description</th>
                  <th class=\"text-center\">Actions</th>
                </tr>
              </thead>
              <tbody>";

                $status ='';
                $search_media=mysqli_query($dbmo,"SELECT a.id as header_id, a.title as header, c.* FROM `category` a INNER JOIN `cat_media_rel` b on a.id=b.cat_id INNER JOIN `media` c on b.media_id=c.id WHERE a.id = '".$search_category['id']."' and a.acc_id='".$accountDetail['id']."' ORDER BY a.id DESC");

                $countsearch_media=mysqli_num_rows($search_media);

                if($countsearch_media==0){

                  echo "No Media Found";

                }else{
                  while ($media = mysqli_fetch_array($search_media)) {

                  ?>
                    <tr>
                    <td><?php echo $media['id'] ?></td>
                    <td><img src="https://cdn.jpegmini.com/user/images/slider_puffin_jpegmini.jpg" width="100px" alt="thumbnail" class="img-thumbnail"></td>
                    <td><a href="#"><?php echo $media['title'] ?></a></td>
                    <td><?php echo $media['description'] ?></td>
                    <td class=\"text-center\"><a href="#" id="music"><i class="fa fa-play"></i></a>
                    <audio id="player" src="<?php echo $media['path'] ?>"></audio>
                    </td>
                    </tr>

                  <?
                  }
                }
                echo "
                    </tbody>
                  </table>
                </div>
              </div>";
              }
              ?>
      </div>
    </div><!-- <div class="col-9"> -->
  </div>
  </div>
</div>
</main>
<!-- end of main -->

<!-- <script src="/assets/js/datatables.min.js"></script>
<script src="/assets/js/responsive-playlist.js"></script>
<script src="/assets/js/row-reorder.js"></script>
<script src="/assets/js/datatables-row-reorder.js"></script>
<script src="/assets/js/datatables-playlist.js"></script> -->
