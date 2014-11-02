<!-- Modal Metode Upload Photo -->
<div class="modal fade" id="myModalMetodeUploadPhoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h5 class="modal-title" id="myModalLabel"><strong>Please Select One Of The Following Option To Make A Profile Picture</strong></h5>
      </div>
      <div class="modal-body modal-forgotPassword text-center">  
        <br> 
        <div class="row">
          <div class="col-sm-12 col-md-4 col-md-offset-1 ">
            <div class="form-group">
              <button class="btn btn-primary upload-photo">UPLOAD NEW PHOTO</button> 
            </div>
          </div>
          <div class="col-sm-12 col-md-1">
            <div class="form-group">
              <p style="padding:6px 0;">or</p>
            </div>
          </div>
          <div class="col-sm-12 col-md-4">
            <div class="form-group">
              <button class="btn btn-primary available-upload-photo" type="submit">CHOOSE AVAILABLE IMAGE</button>   
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Upload Photo -->
<div class="modal fade" id="myModalUploadPhoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload Image</h4>
      </div>
      <div class="modal-body modal-forgotPassword">   
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public');?>/assets/css/jquery.Jcrop.min.css">
        <script src="<?php echo base_url('public');?>/assets/js/jquery.Jcrop.min.js" type="text/javascript"></script>
        <div align="center" style="display:none;" id="image_thumbnail_form">
          <div class="animation-wait-image">
            <img src="<?php echo base_url("public")."/assets/img/ajax-loader.gif"; ?>" ><br>
            <p>Please Wait</p>
          </div>
          <div id="image_thumbnail" class="jcrop-holder"></div>
          <br style="clear:both;"/>
          <form name="thumbnail" action="<?php echo base_url("photo")."/uploadPhotoThumbnail"?>" method="post" >
            <input type="hidden" name="x" value="" id="x" />
            <input type="hidden" name="y" value="" id="y" />
            <input type="hidden" name="w" value="" id="w" />
            <input type="hidden" name="h" value="" id="h" />
            <input type="hidden" name="uri" value="<?php echo $this->uri->segment(2); ?>" id="uri" />
            <input type="hidden" name="file_name" id="file_name"/>
            <input type="hidden" name="filename_ori" id="filename_ori"/>
            <input type="hidden" name="filename" id="filename"/>
            <button class="btn btn-primary"   name="upload_thumbnail" class="btn-primary" id="save-thumb">Save Thumbnail</button>
          </form>
        </div>

        <div id="image_real">  
          <form name="photo"  enctype="multipart/form-data" method="post" id="uploadform" role="form">
            <div class="form-group">
              <div class="error-image"></div>
              <label for="image">Select Image</label>
              <input type="file" id="image" name="image" accept="image/jpeg">                
            </div>
            <div class="text-center">
              <button class="btn btn-primary" name="upload" class="btn-primary" value="Upload" id="loading-upload-image">Upload</button>
              <img src="<?php echo base_url("public")."/assets/img/ajax-loader.gif"; ?>" id="animation-loading-upload-image" style="display:none">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Avalaible Upload Photo -->
<div class="modal fade" id="myModalAvailableUploadPhoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><strong>Please Select One Of The Following Option To Make A Profile Picture</strong></h4>
      </div>
      <div class="modal-body modal-forgotPassword text-center">
        <script src="<?php echo base_url('public');?>/assets/js/bootstrap/tab.js"></script>
        <ul class="nav nav-tabs" id="myTab">
          <li class="active"><a href="#avatar-tab" data-toggle="tab">Choose From Avatar</a></li>
          <!--   <li><a href="#from-photo-tab" data-toggle="tab">Choose From Photo</a></li> -->
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade active in" id="avatar-tab">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                   <div class="error-image-from-avatar"></div>
                </div>
                <?php foreach ($avatar as $key => $av): ?>
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group" id="avatar-available-photo">
                   <img src="<?php echo $av->filename; ?>" class="modal-profile-photo2-list-ava" width="156px" height="156px;">
                 </div>
               </div>
             <?php  endforeach; ?>
           </div>
         </div>
       </div>
       <div class="tab-pane fade" id="from-photo-tab">...</div>
     </div>

     <form action="<?php echo base_url("photo")."/availablePhoto"; ?>" method="post" id="chooseImageFromAvatar">
      <input type="hidden" id="value-available-image" name="radio-avatar">
    <button class="btn btn-primary"   name="make-me-profile" class="btn-primary text-uppercase " id="make-me-profile">Make Me Profile</button>
  </form>
</div>
</div>
</div>
</div>