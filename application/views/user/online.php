<?php $this->load->view("template/header");?>

	<div class="site-main" id="main">
	<div class="container">
	  <div class="row">
	  
	  	<?php $this->load->view("template/left_nav");?>
	    <!-- end of .left-content -->

			<div class="col-md-9 right-content" id="right-content-user-online">
	   		<section class="match-wrapper" id="online-user">
	            <div class="panel panel-default panel-pmj panel-online">
	              <div class="panel-heading">
	                <h3 class="panel-title">
	                  Online List
	                </h3>
	            	</div>
	             	<div class="panel-body">
	                	<div class="row match-row" id="online-list-content">	
	                		<div class="loadingUserOnline" style="text-align: center; padding-top: 10%;">
	                            <img src="<?php echo base_url("public")?>/assets/img/ajax-loader.gif">
	                         </div>
	    				</div>
	              	</div>
	            </div>
	            
	            <!-- end of .panel.panel-default.panel-pmj.panel-match -->
	         </section>
			</div>
			<!-- end of .right-content -->

	  </div>
	</div>
	<!-- end of .container -->
	</div>
	
<?php $this->load->view("template/box_online_user");?>
<?php $this->load->view("template/footer");?>
<script src="<?php echo base_url()?>public/assets/js/online_list.js"></script>


